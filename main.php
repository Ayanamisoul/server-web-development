<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой блог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td>
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <h2><a href="/article/<?= $article['id'] ?>"><?= htmlspecialchars($article['name']) ?></a></h2>
                    <p><?= htmlspecialchars(mb_substr($article['text'], 0, 100)) ?><?= mb_strlen($article['text']) > 100 ? '...' : '' ?></p>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Пока нет статей.</p>
            <?php endif; ?>
        </td>

        <td width="300px" class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <li><a href="/">Главная страница</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
    </tr>
</table>

</body>
</html>
