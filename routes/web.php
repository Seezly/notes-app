<?php

/*
    * Web Routes 
*/

$router->get('/dashboard', 'dashboard.php')->middleware('auth')->middleware('admin');

$router->get('/notes', 'Notes/index.php')->middleware('auth');
$router->get('/api/notes', 'Notes/index.php')->middleware('auth');
$router->post('/api/notes', 'Notes/create.php')->middleware('auth');
$router->put('/api/notes', 'Notes/edit.php')->middleware('auth');
$router->delete('/api/notes', 'Notes/delete.php')->middleware('auth');

$router->get('/tags', 'Tags/index.php')->middleware('auth');
$router->get('/api/tags', 'Tags/index.php')->middleware('auth');
$router->post('/api/tags', 'Tags/create.php')->middleware('auth');
$router->put('/api/tags', 'Tags/edit.php')->middleware('auth');
$router->delete('/api/tags', 'Tags/delete.php')->middleware('auth');

$router->get('/login', 'Auth/login.php')->middleware('guest');
$router->post('/login', 'Auth/login.php')->middleware('guest');

$router->get('/register', 'Auth/register.php')->middleware('guest');
$router->post('/register', 'Auth/register.php')->middleware('guest');

$router->delete('/logout', 'Auth/logout.php');

$router->get('/admin', 'Admin/admin.php')->middleware('admin');
$router->get('/users', 'Admin/User/index.php')->middleware('admin');
