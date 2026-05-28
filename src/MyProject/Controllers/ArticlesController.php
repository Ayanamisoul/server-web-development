<?php

namespace MyProject\Controllers;

use PDO;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class ArticlesController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Показать одну статью по ID с автором
     */
    public function show(int $id): void
    {
        // Получаем статью
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) {
            http_response_code(404);
            echo 'Статья не найдена';
            return;
        }

        // Получаем автора статьи из таблицы users
        $author = null;
        if (!empty($row['author_id'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$row['author_id']]);
            $userRow = $stmt->fetch();
            if ($userRow) {
                $author = new User($userRow['nickname']);
            }
        }

        if (!$author) {
            $author = new User('Неизвестный');
        }

        $article = new Article($row['name'], $row['text'], $author);

        require __DIR__ . '/../../../article.php';
    }

    /**
     * Список всех статей для главной страницы
     */
    public function index(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
