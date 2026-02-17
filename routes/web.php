<?php

/*
    * Web Routes 
*/

$router->get('/dashboard', 'dashboard.php')->middleware('auth');

$router->get('/login', 'Auth/login.php')->middleware('guest');
$router->post('/login', 'Auth/login.php')->middleware('guest');

$router->get('/register', 'Auth/register.php')->middleware('guest');
$router->post('/register', 'Auth/register.php')->middleware('guest');

$router->delete('/logout', 'Auth/logout.php');

$router->get('/admin', 'Admin/admin.php')->middleware('admin');

/* 
    * API Routes 
*/

$router->any('/api/notes', 'Api/note.php')->middleware('auth');
