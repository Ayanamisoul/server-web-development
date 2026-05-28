<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Services\Db;
use MyProject\View\View;

class ArticlesController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = trim($_POST['name'] ?? '');
            $newText = trim($_POST['text'] ?? '');

            if ($newName !== '' && $newText !== '') {
                $db = new Db();
                $db->query(
                    "UPDATE `articles` SET `name` = :name, `text` = :text WHERE `id` = :id",
                    [':name' => $newName, ':text' => $newText, ':id' => $articleId]
                );

                header("Location: /article/$articleId");
                exit;
            }
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }
}
