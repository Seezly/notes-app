<?php

use App\Middlewares\Auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        return view('register', [
            'title' => 'Register',
            'error' => 'Passwords do not match'
        ]);
    }

    $auth = new Auth($connection);
    $user = $auth->register($name, $email, $password, false);

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
