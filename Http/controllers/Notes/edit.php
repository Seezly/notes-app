<?php

use App\Forms\NoteForm;
use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

header('Content-Type: application/json');

$note_data = json_decode(file_get_contents('php://input'), true);

if (!Session::validateCsrf($note_data['csrf_token'])) {
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

$form = (new NoteForm($note_data))->validate($note_data);

$sql = "UPDATE notes SET name = :name, priority = :priority, date = :date, body = :body WHERE id = :id AND user_id = :user_id";
$note = $connection->update($sql, [
    'name' => $note_data['name'],
    'priority' => $note_data['priority'],
    'date' => $note_data['date'],
    'body' => $note_data['body'],
    'id' => $note_data['id'],
    'user_id' => Auth::user(),
]);

Session::renewCsrf();

Log::create($connection, 'edit', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(201);
echo json_encode([
    'success' => $note ? true : false,
]);

exit();
