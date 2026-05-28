<?php include __DIR__ . '/../header.php'; ?>

<h1><?= htmlspecialchars($article->getName()) ?></h1>
<p><?= nl2br(htmlspecialchars($article->getText())) ?></p>
<p><strong>Автор:</strong> <?= htmlspecialchars($article->getAuthor()->getNickname()) ?></p>
<p><a href="/article/<?= $article->getId() ?>/edit">✏️ Редактировать статью</a></p>
<p><a href="/">← Назад к списку</a></p>

<?php include __DIR__ . '/../footer.php'; ?>
