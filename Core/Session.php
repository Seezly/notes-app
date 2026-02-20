<?php

namespace Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            static::csrf();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? null;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value)
    {
        return $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash()
    {
        unset($_SESSION['_flash']);
    }

    public static function clear()
    {
        session_unset();
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function csrf()
    {
        if (!isset($_SESSION['csrf_token'])) {
            return $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function validateCsrf($token)
    {
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function renewCsrf()
    {
        unset($_SESSION['csrf_token']);
        return $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
