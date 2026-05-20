<?php
define('NOTEBOOK', true);

require_once 'db.php';
require_once 'menu.php';

$page = $_GET['page'] ?? 'view';
$allowedPages = ['view', 'add', 'edit', 'delete'];
if (!in_array($page, $allowedPages, true)) {
    $page = 'view';
}

$content = '';

switch ($page) {
    case 'view':
        require_once 'viewer.php';
        $sort = $_GET['sort'] ?? 'id';
        $p = isset($_GET['p']) ? (int) $_GET['p'] : 1;
        if ($p < 1) $p = 1;
        $content = renderViewer($db, $sort, $p);
        break;

    case 'add':
        require_once 'add.php';
        $content = renderAdd($db);
        break;

    case 'edit':
        require_once 'edit.php';
        $content = renderEdit($db);
        break;

    case 'delete':
        require_once 'delete.php';
        $content = renderDelete($db);
        break;
}

$menuHtml = renderMenu();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2 style="color:#fff; margin:0;">Записная книжка</h2>
    </header>

    <main>
        <?= $menuHtml ?>
        <hr style="border:0; border-top:1px solid #ccc; margin:10px 0;">
        <?= $content ?>
    </main>

    <footer></footer>
</body>
</html>
