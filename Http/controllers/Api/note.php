<?php

use Http\Models\Note;

switch ($method) {
    case 'GET':
        return Note::get($connection, $_GET['id'] ?? null, $_GET['csrf_token']);
        break;

    case 'POST':
        return Note::create($connection, json_decode(file_get_contents('php://input'), true));
        break;

    case 'DELETE':
        return Note::delete($connection, json_decode(file_get_contents('php://input'), true)['id'], json_decode(file_get_contents('php://input'), true)['csrd_token']);
        break;

    case 'PUT':
        return Note::update($connection, json_decode(file_get_contents('php://input'), true));
        break;

    case 'PATCH':
        return Note::update($connection, json_decode(file_get_contents('php://input'), true));
        break;

    default:
        return Note::get($connection, $_GET['id'] ?? null, $_GET['csrf_token']);
        break;
}
