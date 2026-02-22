<?php

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

header('Content-Type: application/json');

$tag_input = json_decode(file_get_contents("php://input"), true);

if (!Session::validateCsrf($tag_input['csrf_token'])) {
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

$sql = "UPDATE tags SET deleted_at = NULL WHERE id = :id";

$tag = $connection->query($sql, [
    'id' => $tag_input['id'],
]);

Session::renewCsrf();

Log::create($connection, 'edit', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(200);
echo json_encode([
    'success' => $tag ? true : false
]);

exit();
