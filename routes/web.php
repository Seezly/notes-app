<?php

/*
    * Web Routes 
*/

$router->get('/dashboard', 'dashboard.php')->middleware('auth');
$router->get('/profile', 'profile.php')->middleware('auth');
$router->put('/profile', 'Admin/User/edit.php')->middleware('auth');
$router->delete('/profile', 'Admin/User/delete.php')->middleware('auth');

/*
    * NOTES ROUTES 
*/

$router->get('/notes', 'Notes/index.php')->middleware('auth');
$router->get('/api/notes', 'Notes/index.php')->middleware('auth');
$router->post('/api/notes', 'Notes/create.php')->middleware('auth');
$router->put('/api/notes', 'Notes/edit.php')->middleware('auth');
$router->patch('/api/notes', 'Notes/restore.php')->middleware('admin');
$router->delete('/api/notes', 'Notes/delete.php')->middleware('auth');

/*
    * TAGS ROUTES 
*/

$router->get('/tags', 'Tags/index.php')->middleware('auth');
$router->get('/api/tags', 'Tags/index.php')->middleware('auth');
$router->post('/api/tags', 'Tags/create.php')->middleware('auth');
$router->put('/api/tags', 'Tags/edit.php')->middleware('auth');
$router->patch('/api/tags', 'Tags/restore.php')->middleware('admin');
$router->delete('/api/tags', 'Tags/delete.php')->middleware('auth');

/*
    * AUTH ROUTES 
*/

$router->get('/login', 'Auth/login.php')->middleware('guest');
$router->post('/login', 'Auth/login.php')->middleware('guest');

$router->get('/register', 'Auth/register.php')->middleware('guest');
$router->post('/register', 'Auth/register.php')->middleware('guest');

$router->delete('/logout', 'Auth/logout.php');

/*
    * ADMIN ROUTES 
*/

$router->get('/admin', 'Admin/admin.php')->middleware('admin');
$router->get('/users', 'Admin/User/index.php')->middleware('admin');
$router->patch('/users', 'Admin/User/restore.php')->middleware('admin');
