<h2><?= htmlspecialchars($article['title']) ?></h2>
<p><?= nl2br(htmlspecialchars($article['text'])) ?></p>
<hr>
<?php if ($author): ?>
    <p><strong>Автор:</strong> <?= htmlspecialchars($author['nickname']) ?></p>
<?php else: ?>
    <p><strong>Автор:</strong> неизвестен</p>
<?php endif; ?>
