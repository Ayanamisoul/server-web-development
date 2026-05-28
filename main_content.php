<?php if (!empty($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <h2><a href="/article/<?= $article['id'] ?>"><?= htmlspecialchars($article['title']) ?></a></h2>
        <p><?= htmlspecialchars(mb_substr($article['text'], 0, 100)) ?><?= mb_strlen($article['text']) > 100 ? '...' : '' ?></p>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Пока нет статей.</p>
<?php endif; ?>
