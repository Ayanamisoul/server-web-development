<?php

/**
 * Контроллер для работы со статьями
 */
class ArticlesController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Показать одну статью по ID
     */
    public function show(int $id): void
    {
        // Получаем статью
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            $pageTitle = 'Статья не найдена';
            $content = '<h2>Ошибка 404</h2><p>Статья не найдена.</p>';
            require __DIR__ . '/../layout.php';
            return;
        }

        // Получаем автора статьи
        $author = null;
        if (!empty($article['user_id'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$article['user_id']]);
            $author = $stmt->fetch();
        }

        $pageTitle = $article['title'];
        $contentFile = __DIR__ . '/../article_content.php';
        require __DIR__ . '/../layout.php';
    }

    /**
     * Список всех статей (для главной страницы)
     */
    public function index(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
