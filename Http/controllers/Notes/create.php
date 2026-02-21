<?php

use App\Middlewares\Auth;
use App\Forms\NoteForm;
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

$sql = "INSERT INTO notes (name, priority, date, user_id, body, tag_id) VALUES (:name, :priority, :date, :user_id, :body, :tag_id)";
$note = $connection->insert($sql, [
    'name' => $note_data['name'],
    'priority' => $note_data['priority'],
    'date' => $note_data['date'],
    'user_id' => Auth::user(),
    'body' => $note_data['body'],
    'tag_id' => $note_data['tag_id'] ?? null,
]);

Session::renewCsrf();

Log::create($connection, 'add', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

http_response_code(201);
echo json_encode([
    'success' => $note ? true : false,
]);

exit();
