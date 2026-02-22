<?php

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

header('Content-Type: application/json');

$user_input = json_decode(file_get_contents("php://input"), true);

if (!Session::validateCsrf($user_input['csrf_token'])) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Invalid CSRF Token'
    ]);
    exit();
}

if (!Auth::isAdmin()) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Unauthorized. You must login.'
    ]);
    exit();
}

$sql = "UPDATE users SET deleted_at = NULL WHERE id = :id";

$user = $connection->query($sql, [
    'id' => $user_input['user_id']
]);

Session::renewCsrf();

Log::create($connection, 'edit', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(200);
echo json_encode([
    'success' => $user ? true : false
]);

exit();
