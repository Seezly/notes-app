<?php

use Http\Models\Tag;

switch ($method) {
    case 'GET':
        return Tag::get($connection, $_GET['id'] ?? null);
        break;

    case 'POST':
        return Tag::create($connection, json_decode(file_get_contents('php://input'), true));
        break;

    case 'DELETE':
        return Tag::delete($connection, json_decode(file_get_contents('php://input'), true));
        break;

    case 'PUT':
        return Tag::update($connection, json_decode(file_get_contents('php://input'), true));
        break;

    case 'PATCH':
        return Tag::update($connection, json_decode(file_get_contents('php://input'), true));
        break;

    default:
        return Tag::get($connection, $_GET['id'] ?? null);
        break;
}
