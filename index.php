<?php

/**
 * Точка входа приложения с PSR-4 автозагрузкой.
 */

// Автозагрузка классов по PSR-4
spl_autoload_register(function (string $className) {
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Роут /article/\d+ — просмотр статьи
if (preg_match('~^article/(\d+)$~', $uri, $matches)) {
    (new ArticlesController())->view((int)$matches[1]);
    exit;
}

// Роут /article/\d+/edit — редактирование статьи
if (preg_match('~^article/(\d+)/edit$~', $uri, $matches)) {
    (new ArticlesController())->edit((int)$matches[1]);
    exit;
}

// Роут / — главная страница
if ($uri === '' || $uri === 'index.php') {
    (new MainController())->main();
    exit;
}

// 404
http_response_code(404);
$view = new \MyProject\View\View(__DIR__ . '/templates');
$view->renderHtml('errors/404.php', [], 404);
