<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../Core/helpers.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

use App\Exceptions\ValidationException;
use Core\Database;
use Core\Router;
use Core\Session;

Session::start();

$connection = new Database($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

$router = new Router();

$uri = getURI();
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

require asset('routes/web.php');

try {
    $router->route($uri, $method, $connection);
} catch (ValidationException $e) {
    Session::flash('errors', $e->errors);
    Session::flash('old', $e->old);
    redirect(Router::previousUrl());
}

Session::unflash();
