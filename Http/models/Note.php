<?php

namespace Http\Models;

use App\Middlewares\Auth;
use Core\Session;
use Core\Log;

class Note
{

    public static function create($connection, $noteData = [])
    {
        header('Content-Type: application/json');

        if (!Session::validateCsrf($noteData['csrf_token'])) {
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

        $sql = "INSERT INTO notes (name, priority, date, user_id, body) VALUES (:name, :priority, :date, :user_id, :body)";
        $note = $connection->insert($sql, [
            'name' => $noteData['name'],
            'priority' => $noteData['priority'],
            'date' => $noteData['date'],
            'user_id' => Auth::user(),
            'body' => $noteData['body'],
        ]);
        http_response_code(201);
        echo json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);

        Session::renewCsrf();

        Log::create($connection, 'add', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

        exit();
    }

    public static function get($connection, $id = null, $params = [])
    {
        $data = [];

        $limit = 6;

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

        $sql = "SELECT DISTINCT n.* FROM notes n";

        $bindings = [
            'user_id' => Auth::user(),
        ];

        if (isset($params['tag'])) {
            $sql .= "
            JOIN notes_tags nt ON nt.note_id = n.id 
            JOIN tags t ON nt.tag_id = t.id";
        }

        $sql .= " WHERE n.user_id = :user_id";

        if (isset($params['tag_f'])) {
            $sql .= " AND t.name = :tag";
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

        if (!Auth::isAdmin()) {
            $sql .= " AND n.deleted_at IS NULL";
        }

        if ($id !== null) {
            header('Content-Type: application/json');
            $sql .= " AND n.id = :id";
            $bindings['id'] = $id;

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

        if ($num_pages >= 1) {
            $data['num_pages'] = $num_pages;
        }

        $data['notes'] = $note;

        http_response_code(200);

        Log::create($connection, 'get', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

        return json_encode([
            'success' => $note ? true : false,
            'data' => $data,
        ]);
    }

    public static function update($connection, $noteData = [])
    {
        header('Content-Type: application/json');

        if (!Session::validateCsrf($noteData['csrf_token'])) {
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

        $sql = "UPDATE notes SET name = :name, priority = :priority, date = :date, body = :body WHERE id = :id AND user_id = :user_id";
        $note = $connection->update($sql, [
            'name' => $noteData['name'],
            'priority' => $noteData['priority'],
            'date' => $noteData['date'],
            'body' => $noteData['body'],
            'id' => $noteData['id'],
            'user_id' => Auth::user(),
        ]);
        http_response_code(201);
        echo json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);

        Session::renewCsrf();

        Log::create($connection, 'edit', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

        exit();
    }

    public static function delete($connection, $id, $token)
    {
        header('Content-Type: application/json');

        if (!Session::validateCsrf($token)) {
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

        $sql = "UPDATE notes SET deleted_at = :date WHERE id = :id AND user_id = :user_id";
        $note = $connection->delete($sql, [
            'date' => date_create(),
            'id' => $id,
            'user_id' => Auth::user(),
        ]);
        http_response_code(200);
        echo json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);

        Session::renewCsrf();

        Log::create($connection, 'delete', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

        exit();
    }
}
