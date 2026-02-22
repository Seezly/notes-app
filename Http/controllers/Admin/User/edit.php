<?php

use App\Middlewares\Auth;
use App\Forms\ProfileForm;
use Core\Session;
use Core\Log;

header('Content-Type: application/json');

$user_info = $_POST;

if (!Session::validateCsrf($user_info['csrf_token'])) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Invalid CSRF Token'
    ]);
    exit();
}

$form = (new ProfileForm($user_info))->validate($user_info);

$bindings = [
    'name' => $user_info['user_name'],
    'email' => $user_info['email'],
    'id' => Auth::user(),
];


if (isset($user_info['password']) && !empty($user_info['password'])) {
    $sql = "UPDATE users SET username = :name, email = :email, password = :password
        WHERE id = :id";
    $bindings['password'] = password_hash($user_info['password'], PASSWORD_BCRYPT);
} else {
    $sql = "UPDATE users SET username = :name, email = :email
        WHERE id = :id";
}

$user = $connection->update($sql, $bindings);

Session::renewCsrf();

Log::create($connection, 'edit', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

redirect("/profile", 200);
