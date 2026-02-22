<?php

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

$params = $_GET;

$data = [];

$limit = 6;

$page = isset($params['page']) ? (int) $params['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

if (!Auth::user()) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Unauthorized. You must login.'
    ]);
    exit();
}

$sql = "SELECT n.*";

$bindings = [];

if (!Auth::isAdmin()) {
    $sql .= ", t.name AS tag FROM notes n JOIN tags t ON n.tag_id = t.id WHERE n.user_id = :user_id AND n.deleted_at IS NULL";
    $bindings['user_id'] = Auth::user();
} else {
    $sql .= ", t.name AS tag, u.username AS username, u.id AS user_id FROM notes n LEFT JOIN tags t ON n.tag_id = t.id LEFT JOIN users u ON n.user_id = u.id";
}

if (isset($params['tag_f'])) {
    $sql .= " AND t.id = :tag";
    $bindings['tag'] = $params['tag_f'];
}

if (isset($params['q'])) {
    $sql .= " AND (n.name LIKE :q OR n.body LIKE :q)";
    $bindings['q'] = "%{$params['q']}%";
}

if (isset($params['date_f'])) {
    $sql .= " AND n.date = :date";
    $bindings['date'] = $params['date_f'];
}

if (isset($params['priority_f'])) {
    $sql .= " AND n.priority = :priority";
    $bindings['priority'] = $params['priority_f'];
}

if (isset($params['id']) && $params['id'] !== null) {
    header('Content-Type: application/json');
    $sql .= " AND n.id = :id";
    $bindings['id'] = $params['id'];

    $note = $connection->query($sql, $bindings)->getOne();

    echo json_encode([
        'success' => $note ? true : false,
        'data' => $note,
    ]);
    exit();
}

$num_rows = $connection->query($sql, $bindings)->getRowCount();

$sql .= " LIMIT {$limit} OFFSET {$offset}";

$note = $connection->query($sql, $bindings)->getAll();

$num_pages = ceil($num_rows / $limit);

$window = 2;

$start_page = max(1, $page - $window);

$end_page = min($num_pages, $page + $window);

if ($num_pages >= 1) {
    $data['pagination'] = [
        'num_pages' => $num_pages,
        'window' => $window,
        'current_page' => $page,
        'start_page' => $start_page,
        'end_page' => $end_page
    ];
}

$data['notes'] = $note;

Log::create($connection, 'get', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

return view('dashboard', [
    'title' => 'Dashboard',
    'data' => $data
]);
