<?php

/**
 * Скрипт инициализации базы данных.
 * Создаёт таблицы users и articles, добавляет тестовые данные.
 */

require_once __DIR__ . '/db.php';

// Создание таблицы пользователей
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nickname TEXT NOT NULL
    )
");

// Создание таблицы статей
$pdo->exec("
    CREATE TABLE IF NOT EXISTS articles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        text TEXT NOT NULL,
        user_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )
");

// Очистка старых данных
$pdo->exec("DELETE FROM articles");
$pdo->exec("DELETE FROM users");
$pdo->exec("DELETE FROM sqlite_sequence WHERE name='articles'");
$pdo->exec("DELETE FROM sqlite_sequence WHERE name='users'");

// Добавление тестовых пользователей
$stmt = $pdo->prepare("INSERT INTO users (nickname) VALUES (?)");
$stmt->execute(['Мария']);
$stmt->execute(['Иван']);

// Добавление тестовых статей
$stmt = $pdo->prepare("INSERT INTO articles (title, text, user_id) VALUES (?, ?, ?)");
$stmt->execute(['Статья 1', 'Всем привет, это текст первой статьи', 1]);
$stmt->execute(['Статья 2', 'Всем привет, это текст второй статьи', 2]);

echo "База данных инициализирована успешно." . PHP_EOL;
