<?php

$sql = "SELECT * FROM users WHERE id = :id";

$user = $connection->query($sql, [
    'id' => \App\Middlewares\Auth::user()
])->getOne();

return view("profile", [
    'title' => 'Profile',
    'data' => $user
]);
