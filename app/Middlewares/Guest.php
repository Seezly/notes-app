<?php

namespace App\Middlewares;

use App\Middlewares\Auth;

class Guest
{
    public function handle()
    {
        if (Auth::user()) {
            redirect('/dashboard');
        }
    }
}
