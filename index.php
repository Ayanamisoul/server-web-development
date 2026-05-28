<?php

/**
 * Точка входа приложения с PSR-4 автозагрузкой и layout-шаблоном.
 */

// Автозагрузка классов по PSR-4
spl_autoload_register(function (string $className) {
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use MyProject\Controllers\SayController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$parts = explode('/', $uri);

// Роут / — главная страница
if ($uri === '' || $uri === 'index.php') {
    $contentFile = __DIR__ . '/main.php';
    require __DIR__ . '/layout.php';
    exit;
}

// Роут /about-me
if ($uri === 'about-me') {
    $pageTitle = 'Обо мне';
    $contentFile = __DIR__ . '/about.php';
    require __DIR__ . '/layout.php';
    exit;
}

// Роут /hello/$name
if (count($parts) === 2 && $parts[0] === 'hello') {
    $name = urldecode($parts[1]);
    $controller = new SayController();
    $controller->sayHello($name);
    exit;
}

// Роут /bye/$name
if (count($parts) === 2 && $parts[0] === 'bye') {
    $name = urldecode($parts[1]);
    $controller = new SayController();
    $controller->sayBye($name);
    exit;
}

// Демонстрация моделей
if ($uri === 'demo') {
    $author = new \MyProject\Models\Users\User('Иван');
    $article = new \MyProject\Models\Articles\Article('Заголовок', 'Текст', $author);
    var_dump($article);
    exit;
}

// 404
http_response_code(404);
$pageTitle = '404 Not Found';
$content = '<h2>Ошибка 404</h2><p>Страница не найдена.</p>';
require __DIR__ . '/layout.php';
