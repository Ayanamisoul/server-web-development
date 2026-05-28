<?php

/**
 * Точка входа приложения с PSR-4 автозагрузкой.
 */

require_once __DIR__ . '/db.php';

// Автозагрузка классов по PSR-4
spl_autoload_register(function (string $className) {
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use MyProject\Controllers\ArticlesController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$parts = explode('/', $uri);

// Роут / — главная страница со списком статей
if ($uri === '' || $uri === 'index.php') {
    $controller = new ArticlesController($pdo);
    $articles = $controller->index();
    require __DIR__ . '/main.php';
    exit;
}

// Роут /article/\d+ — просмотр одной статьи
if (count($parts) === 2 && $parts[0] === 'article' && is_numeric($parts[1])) {
    $controller = new ArticlesController($pdo);
    $controller->show((int)$parts[1]);
    exit;
}

// 404
http_response_code(404);
echo '404 Not Found';
