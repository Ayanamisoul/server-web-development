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

use MyProject\Controllers\SayController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$parts = explode('/', $uri);

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

// Демонстрация моделей (для проверки PSR-4)
if ($uri === 'demo') {
    $author = new \MyProject\Models\Users\User('Иван');
    $article = new \MyProject\Models\Articles\Article('Заголовок', 'Текст', $author);
    var_dump($article);
    exit;
}

// 404
http_response_code(404);
echo '404 Not Found';
