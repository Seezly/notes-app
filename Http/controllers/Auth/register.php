<?php

use App\Middlewares\Auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attributes = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password'],
        'token' => $_POST['csrf_token']
    ];

    if ($attributes['password'] !== $attributes['confirm_password']) {
        return view('register', [
            'title' => 'Register',
            'error' => 'Passwords do not match'
        ]);
    }

    $auth = (new Auth($connection))
        ->register(
            $attributes['name'],
            $attributes['email'],
            $attributes['password'],
            $attributes['token'],
            false
        );

    if ($user) {
        redirect('/dashboard');
    } else {
        return view('register', [
            'title' => 'Register',
            'error' => 'Registration failed'
        ]);
    }
}

return view('register', [
    'title' => 'Register'
]);
