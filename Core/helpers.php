<?php

$BASE_URL = __DIR__ . '/..';

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function getURI()
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

function authorize($condition, $status = 403)
{
    if (!$condition) {
        abort($status);
    }
}

function redirect($url, $status = 302)
{
    http_response_code($status);
    header("Location: $url");
    die();
}

function view($path, $data = [])
{
    extract($data);
    return require asset("views/{$path}.php");
}

function asset($path)
{
    global $BASE_URL;
    return $BASE_URL . '/' . $path;
}

function abort($code = 404)
{
    http_response_code($code);

    if (file_exists(asset("views/{$code}.php"))) {
        require asset("views/{$code}.php");
    } else {
        echo "Error {$code}";
    }
}
