<?php

/**
 * Простой роутер
 */

require_once __DIR__ . '/controllers/SayController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$parts = explode('/', $uri);

$controller = new SayController();

// Роут / — главная страница
if ($uri === '' || $uri === 'index.php') {
    require __DIR__ . '/main.php';
    exit;
}

// Роут /about-me
if ($uri === 'about-me') {
    require __DIR__ . '/about.php';
    exit;
}

// Роут /hello/$name
if (count($parts) === 2 && $parts[0] === 'hello') {
    $controller->sayHello(urldecode($parts[1]));
    exit;
}

// Роут /bye/$name
if (count($parts) === 2 && $parts[0] === 'bye') {
    $controller->sayBye(urldecode($parts[1]));
    exit;
}

// 404 — роут не найден
http_response_code(404);
echo '404 Not Found';
