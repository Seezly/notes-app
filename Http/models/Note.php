<?php

namespace Http\Models;

use App\Middlewares\Auth;

class Note
{

    public static function create($connection, $noteData = [])
    {
        header('Content-Type: application/json');
        $sql = "INSERT INTO notes (name, priority, date, user_id, body) VALUES (:name, :priority, :date, :user_id, :body)";
        $note = $connection->insert($sql, [
            'name' => htmlspecialchars($noteData['name']),
            'priority' => $noteData['priority'],
            'date' => $noteData['date'],
            'user_id' => Auth::user(),
            'body' => htmlspecialchars($noteData['body']),
        ]);
        echo json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);
        exit();
    }

    public static function get($connection, $id = null)
    {

        $sql = "SELECT * FROM notes WHERE user_id = :user_id";

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

        return json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);
    }

    public static function update($connection, $noteData = [])
    {
        header('Content-Type: application/json');

        $sql = "UPDATE notes SET name = :name, priority = :priority, date = :date, body = :body WHERE id = :id AND user_id = :user_id";
        $note = $connection->update($sql, [
            'name' => htmlspecialchars($noteData['name']),
            'priority' => $noteData['priority'],
            'date' => $noteData['date'],
            'body' => htmlspecialchars($noteData['body']),
            'id' => $noteData['id'],
            'user_id' => Auth::user(),
        ]);

        echo json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);
        exit();
    }

    public static function delete($connection, $id)
    {
        header('Content-Type: application/json');
        $sql = "DELETE FROM notes WHERE id = :id AND user_id = :user_id";
        $note = $connection->delete($sql, [
            'id' => $id,
            'user_id' => Auth::user(),
        ]);

        echo json_encode([
            'success' => $note ? true : false,
            'data' => $note,
        ]);
        exit();
    }
}
