<?php
/**
 * Общий layout-шаблон.
 * Переменные:
 * - $pageTitle (по умолчанию "Мой блог")
 * - $contentFile — путь к файлу с контентом
 */
$pageTitle = $pageTitle ?? 'Мой блог';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
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
            <?php
            if (isset($contentFile)) {
                require $contentFile;
            } elseif (isset($content)) {
                echo $content;
            }
            ?>
        </td>

        <td width="300px" class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <li><a href="/">Главная страница</a></li>
                <li><a href="/about-me">Обо мне</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
    </tr>
</table>

</body>
</html>
