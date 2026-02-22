<?php

namespace App\Middlewares;

use App\Middlewares\Auth;

class Admin extends Auth
{
    public function handle()
    {
        parent::handle();

        if (!static::isAdmin() && !static::user()) {
            redirect('/login');
        }

        if (!static::isAdmin() && static::user()) {
            redirect('/dashboard');
        }
    }
}
