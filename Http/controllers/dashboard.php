<?php

use Http\Models\Note;
use App\Middlewares\Auth;

$data = json_decode(Note::get($connection, params: $_GET), true)['data'] ?? [];

return view('dashboard', [
    'title' => 'Dashboard',
    'data' => $data
]);
