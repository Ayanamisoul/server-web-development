<?php

/**
 * Роутер приложения.
 * Для каждого роута задаётся $pageTitle (по умолчанию "Мой блог" в layout.php)
 * и подключается нужный файл контента через общий layout-шаблон.
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$parts = explode('/', $uri);

// Роут / — главная страница
if ($uri === '' || $uri === 'index.php') {
    $contentFile = __DIR__ . '/main_content.php';
    require __DIR__ . '/layout.php';
    exit;
}

// Роут /about-me
if ($uri === 'about-me') {
    $pageTitle = 'Обо мне';
    $contentFile = __DIR__ . '/about_content.php';
    require __DIR__ . '/layout.php';
    exit;
}

// Роут /hello/$name
if (count($parts) === 2 && $parts[0] === 'hello') {
    $pageTitle = 'Страница приветствия';
    $name = urldecode($parts[1]);
    $contentFile = __DIR__ . '/hello_content.php';
    require __DIR__ . '/layout.php';
    exit;
}

// Роут /bye/$name
if (count($parts) === 2 && $parts[0] === 'bye') {
    $pageTitle = 'Прощание';
    $name = urldecode($parts[1]);
    $contentFile = __DIR__ . '/bye_content.php';
    require __DIR__ . '/layout.php';
    exit;
}

// 404 — роут не найден
http_response_code(404);
$pageTitle = '404 Not Found';
$content = '<h2>Ошибка 404</h2><p>Страница не найдена.</p>';
require __DIR__ . '/layout.php';
