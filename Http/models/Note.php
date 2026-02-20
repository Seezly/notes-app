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
            'name' => htmlspecialchars($noteData['name']),
            'priority' => $noteData['priority'],
            'date' => $noteData['date'],
            'user_id' => Auth::user(),
            'body' => htmlspecialchars($noteData['body']),
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

    public static function get($connection, $id = null)
    {

        if (!Auth::user()) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'data' => 'Unauthorized. You must login.'
            ]);
            exit();
        }

        $sql = "SELECT * FROM notes WHERE user_id = :user_id";

        if (!Auth::isAdmin()) {
            $sql .= " AND deleted_at IS NULL";
        } else {
            $sql .= " AND deleted_at IS NOT NULL";
        }

        if ($id !== null) {
            header('Content-Type: application/json');
            $sql .= " AND id = :id";

            $note = $connection->query($sql, [
                'user_id' => Auth::user(),
                'id' => $id,
            ])->getOne();

            echo json_encode([
                'success' => $note ? true : false,
                'data' => $note,
            ]);
            exit();
        }

        $note = $connection->query($sql, [
            'user_id' => Auth::user(),
        ])->getAll();

        http_response_code(200);

        Session::renewCsrf();

        Log::create($connection, 'get', Auth::user(), $_SERVER['REMOTE_ADDR'], getURI());

        return json_encode([
            'success' => $note ? true : false,
            'data' => $note,
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
            'name' => htmlspecialchars($noteData['name']),
            'priority' => $noteData['priority'],
            'date' => $noteData['date'],
            'body' => htmlspecialchars($noteData['body']),
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
