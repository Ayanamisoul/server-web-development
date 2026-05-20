<?php
if (!defined('NOTEBOOK')) {
    die('Прямой доступ запрещен');
}

$dbFile = __DIR__ . '/notebook.db';
$dsn = 'sqlite:' . $dbFile;

$db = new PDO($dsn);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// Создаем таблицу, если не существует
$db->exec("
    CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        surname TEXT NOT NULL,
        name TEXT NOT NULL,
        lastname TEXT,
        gender TEXT,
        birthdate TEXT,
        phone TEXT,
        address TEXT,
        email TEXT,
        comment TEXT
    )
");
