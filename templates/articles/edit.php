<?php include __DIR__ . '/../header.php'; ?>

<h2>Редактирование статьи</h2>

<form method="POST" action="/article/<?= $article->getId() ?>/edit">
    <div style="margin-bottom: 15px;">
        <label for="name" style="display: block; font-weight: bold;">Заголовок:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($article->getName()) ?>" style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="text" style="display: block; font-weight: bold;">Текст:</label>
        <textarea id="text" name="text" rows="10" style="width: 100%; padding: 8px; margin-top: 5px;"><?= htmlspecialchars($article->getText()) ?></textarea>
    </div>

    <button type="submit" style="padding: 10px 20px; cursor: pointer;">Сохранить</button>
    <a href="/article/<?= $article->getId() ?>" style="margin-left: 10px;">Отмена</a>
</form>

<?php include __DIR__ . '/../footer.php'; ?>
