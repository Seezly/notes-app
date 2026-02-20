<?php

use App\Middlewares\Auth;

use App\Forms\RegisterForm;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attributes = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password'],
        'token' => $_POST['csrf_token']
    ];

    $form = (new RegisterForm($attributes))
        ->validate($attributes);

    $auth = (new Auth($connection))
        ->register(
            $attributes['name'],
            $attributes['email'],
            $attributes['password'],
            $attributes['token'],
            false
        );

    if (!$auth) {
        $form
            ->addError("registration", "Registration failed. Please try again later.")
            ->throwIfNotValid();
    }

    return redirect('/dashboard', 201);
}

return view('register', [
    'title' => 'Register',
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? []
]);
