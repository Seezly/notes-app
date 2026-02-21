<?php

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

$params = $_GET;

$data = [];

$window = 2;
$limit = 10;

$page = isset($params['page']) ? (int) $params['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

if (!Auth::user()) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'data' => 'Unauthorized. You must login.'
    ]);
    exit();
}

$sql = "SELECT * FROM tags";

$bindings = [
    'user_id' => Auth::user()
];

if (!Auth::isAdmin()) {
    $sql .= "  WHERE user_id = :user_id AND deleted_at IS NULL";
}

if (isset($params['id']) && $params['id'] !== null) {
    header("Content-Type: application/json");

    $sql .= " AND id = :id";
    $bindings['id'] = $params['id'];

    $tag = $connection->query($sql, $bindings)->getOne();

    http_response_code(200);

    echo json_encode([
        'success' => $tag ? true : false,
        'data' => $tag
    ]);
    exit();
}

$sql .= " LIMIT {$limit} OFFSET {$offset}";

$tags = $connection->query($sql, $bindings)->getAll();

$num_pages = ceil($connection->query($sql, $bindings)->getRowCount() / $limit);

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

$data['tags'] = $tags;

Log::create($connection, 'get', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());


if (getUri() === "/api/tags") {
    header('Content-Type: application/json');

    http_response_code(200);
    echo json_encode([
        'success' => $tags ? true : false,
        'data' => $data,
    ]);
    exit();
}

return view('tags', [
    'title' => 'Tags',
    'data' => $data
]);
