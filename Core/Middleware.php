<?php

namespace Core;

use App\Middlewares\Auth;
use App\Middlewares\Admin;
use App\Middlewares\Guest;

class Middleware
{
    public static $middlewares = [
        'auth' => Auth::class,
        'guest' => Guest::class,
        'admin' => Admin::class,
    ];

    public static function resolve($key)
    {
        if (static::$middlewares[$key] ?? false) {
            $middleware = static::$middlewares[$key];
            return (new $middleware)->handle();
        }

        return new \Exception("Middleware {$key} not found.");
    }
}
