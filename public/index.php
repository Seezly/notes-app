<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../Core/helpers.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

use App\Exceptions\ValidationException;
use Core\Database;
use Core\Router;
use Core\Session;

$connection = new Database('localhost', 'root', '', 'notes_app');

$router = new Router();

$uri = getURI();
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

require asset('routes/web.php');

Session::start();

try {
    $router->route($uri, $method, $connection);
} catch (ValidationException $e) {
    Session::flash('errors', $e->errors);
    Session::flash('old', $e->old);
    redirect(Router::previousUrl());
}

Session::unflash();
