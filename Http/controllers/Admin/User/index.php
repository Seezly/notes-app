<?php

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

if (!Auth::isAdmin()) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Unauthorized. You must login.'
    ]);
    exit();
}

$params = $_GET;

$data = [];

$limit = 6;

$page = isset($params['page']) ? (int) $params['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM users";

$bindings = [];

$num_rows = $connection->query($sql, $bindings)->getRowCount();

$sql .= " LIMIT {$limit} OFFSET {$offset}";

$users = $connection->query($sql, $bindings)->getAll();

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

$data['users'] = $users;

Log::create($connection, 'get', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

return view('users', [
    'title' => 'Users',
    'data' => $data
]);
