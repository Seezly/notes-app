<?php

use Http\Models\Note;
use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

header("Content-Type: application/json");

$tag_data = json_decode(file_get_contents('php://input'), true);

if (!Session::validateCsrf($tag_data['csrf_token'])) {
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

$sql = "UPDATE tags SET deleted_at = :date WHERE id = :id AND user_id = :user_id";

$tag = $connection->query($sql, [
    'date' => date('Y-m-d H:i:s'),
    'id' => $tag_data['id'],
    'user_id' => Auth::user()
]);

Session::renewCsrf();

Log::create($connection, 'delete', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(200);
echo json_encode([
    'success' => $tag ? true : false,
    'data' => $tag
]);

exit();
