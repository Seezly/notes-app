<?php

use Http\Models\Note;
use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

header('Content-Type: application/json');

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

$sql = "INSERT INTO tags (name, user_id) VALUES (:name, :user_id)";

$tag = $connection->query($sql, [
    'name' => $tag_data['name'],
    'user_id' => Auth::user()
]);

Session::renewCsrf();

Log::create($connection, 'add', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(201);
echo json_encode([
    'success' => $tag ? true : false,
    'data' => $tag,
]);

exit();
