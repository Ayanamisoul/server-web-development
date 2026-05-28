<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article->getTitle()) ?></title>
    <link rel="stylesheet" href="/style.css">
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
            <h2><?= htmlspecialchars($article->getTitle()) ?></h2>
            <p><?= nl2br(htmlspecialchars($article->getText())) ?></p>
            <hr>
            <p><strong>Автор:</strong> <?= htmlspecialchars($article->getAuthor()->getName()) ?></p>
            <p><a href="/">← Назад к списку статей</a></p>
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
