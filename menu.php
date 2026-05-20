<?php
if (!defined('NOTEBOOK')) {
    die('Прямой доступ запрещен');
}

/**
 * Формирует HTML-код основного меню и подменю сортировки.
 * @return string HTML-код меню.
 */
function renderMenu(): string {
    $page = $_GET['page'] ?? 'view';
    $sort = $_GET['sort'] ?? 'id';

    $items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];

    $html = '<nav><div style="text-align:center; margin: 10px 0;">';

    foreach ($items as $key => $label) {
        $activeClass = ($page === $key) ? 'active' : '';
        $html .= '<a href="index.php?page=' . $key . '" class="menu-btn ' . $activeClass . '">' . htmlspecialchars($label) . '</a>';
    }

    $html .= '</div>';

    // Подменю сортировки только для просмотра
    if ($page === 'view') {
        $sortOptions = [
            'id' => 'По добавлению',
            'surname' => 'По фамилии',
            'birthdate' => 'По дате рождения',
        ];

        $html .= '<div class="submenu">';
        foreach ($sortOptions as $key => $label) {
            $activeClass = ($sort === $key) ? 'active' : '';
            $html .= '<a href="index.php?page=view&sort=' . $key . '" class="' . $activeClass . '">' . htmlspecialchars($label) . '</a>';
        }
        $html .= '</div>';
    }

    $html .= '</nav>';
    return $html;
}
