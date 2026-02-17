<?php

use App\Middlewares\Auth;

if ($method === 'DELETE') {
    Auth::logout();
}
