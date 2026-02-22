<?php

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

header('Content-Type: application/json');

$user_info = $_POST;

if (!Session::validateCsrf($user_info['csrf_token'])) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Invalid CSRF Token'
    ]);
    exit();
}

if (!Auth::user()) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Unauthorized. You must login.'
    ]);
    exit();
}

$sql = "UPDATE users SET deleted_at = :date WHERE id = :id";
$user = $connection->delete($sql, [
    'date' => date('Y-m-d H:i:s'),
    'id' => Auth::user(),
]);

Session::renewCsrf();

Log::create($connection, 'delete', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

Auth::logout();

exit();
