<?php

/**
 * Подключение к SQLite базе данных
 */

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/blog.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}
