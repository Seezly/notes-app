<?php

namespace App\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    private $connection;
    private static $user;
    private static $is_admin;

    public function __construct($connection = null)
    {
        $this->connection = $connection;

        return $this;
    }

    public function handle()
    {
        $token = $_COOKIE['token'] ?? null;
        $secret = getenv('SECRET_TOKEN_KEY') ?: ($_ENV['SECRET_TOKEN_KEY'] ?? null);

        if (!$token || !$secret) {
            redirect('/login');
        }

        if (!static::user()) {
            redirect('/login');
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $user = $this->connection->query($sql, [
            'email' => $email,
        ])->getOne();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $data = [
            'id' => $user['id'],
            'username' => $user['username'],
            'is_admin' => $user['is_admin'],
        ];

        $secret = getenv('SECRET_TOKEN_KEY') ?: ($_ENV['SECRET_TOKEN_KEY'] ?? null);
        if (!$secret) {
            throw new \RuntimeException('SECRET_TOKEN_KEY is not configured in the environment.');
        }

        $token = JWT::encode($data, $secret, 'HS256');

        setcookie('token', $token, time() + (86400 * 30), "/");

        return $user;
    }

    public function register($username, $email, $password, $is_admin = false)
    {
        $sql = "INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)";
        $this->connection->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'is_admin' => $is_admin ? 1 : 0,
        ]);

        return $this->login($email, $password);
    }

    public static function logout()
    {
        unset($_COOKIE['token']);
        setcookie('token', '', time() - 3600, "/");

        redirect('/login');
    }

    private static function decodeToken()
    {
        if (!isset($_COOKIE['token'])) {
            return null;
        }

        $secret = getenv('SECRET_TOKEN_KEY') ?: ($_ENV['SECRET_TOKEN_KEY'] ?? null);
        if (!$secret) {
            throw new \RuntimeException('SECRET_TOKEN_KEY is not configured in the environment.');
        }

        try {
            return JWT::decode($_COOKIE['token'], new Key($secret, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function user()
    {
        $payload = static::decodeToken();
        return $payload ? $payload->id : null;
    }

    public static function isAdmin()
    {
        $payload = static::decodeToken();
        return $payload ? $payload->is_admin : null;
    }
}
