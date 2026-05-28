<?php

/**
 * Инициализация базы данных для блога.
 * Создаёт таблицы users и articles, добавляет тестовые данные.
 */

require_once __DIR__ . '/db.php';

// Таблица пользователей (адаптировано для SQLite)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nickname TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        is_confirmed INTEGER NOT NULL DEFAULT 0,
        role TEXT NOT NULL CHECK(role IN ('admin', 'user')),
        password_hash TEXT NOT NULL,
        auth_token TEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");

// Таблица статей (адаптировано для SQLite)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS articles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        author_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        text TEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");

// Очистка старых данных
$pdo->exec("DELETE FROM articles");
$pdo->exec("DELETE FROM users");
$pdo->exec("DELETE FROM sqlite_sequence WHERE name='articles'");
$pdo->exec("DELETE FROM sqlite_sequence WHERE name='users'");

// Добавление пользователей
$stmt = $pdo->prepare("
    INSERT INTO users (nickname, email, is_confirmed, role, password_hash, auth_token, created_at)
    VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
");
$stmt->execute(['admin', 'admin@gmail.com', 1, 'admin', 'hash1', 'token1']);
$stmt->execute(['user', 'user@gmail.com', 1, 'user', 'hash2', 'token2']);

// Добавление статей
$stmt = $pdo->prepare("
    INSERT INTO articles (author_id, name, text, created_at)
    VALUES (?, ?, ?, CURRENT_TIMESTAMP)
");
$stmt->execute([1, 'Статья №1', 'Можно взять что-то вроде Lorem Ipsum']);
$stmt->execute([1, 'Статья №2', 'Можно взять что-то вроде Lorem Ipsum']);

echo "База данных инициализирована успешно." . PHP_EOL;
