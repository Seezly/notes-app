<?php

use App\Forms\LoginForm;
use App\Middlewares\Auth;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attributes = [
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'token' => $_POST['csrf_token']
    ];

    $form = (new LoginForm($attributes))
        ->validate($attributes);

    $auth = (new Auth($connection))
        ->login(
            $attributes['email'],
            $attributes['password'],
            $attributes['token']
        );

    if (!$auth) {
        $form
            ->addError('credentials', 'Invalid email or password.')
            ->throwIfNotValid();
    }

    return redirect('/dashboard');
}

return view('login', [
    'title' => 'Login',
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? []
]);
