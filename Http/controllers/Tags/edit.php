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

$sql = "UPDATE tags SET name = :name WHERE id = :id AND user_id = :user_id";
$tag = $connection->update($sql, [
    'name' => $tag_data['name'],
    'id' => $tag_data['id'],
    'user_id' => Auth::user(),
]);

Session::renewCsrf();

Log::create($connection, 'edit', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(201);
echo json_encode([
    'success' => $tag ? true : false,
    'data' => $tag,
]);

exit();
