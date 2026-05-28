<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <h2><a href="/article/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName()) ?></a></h2>
        <p><?= htmlspecialchars(mb_substr($article->getText(), 0, 100)) ?><?= mb_strlen($article->getText()) > 100 ? '...' : '' ?></p>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока нет статей.</p>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
