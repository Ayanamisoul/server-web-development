<?php
if (!defined('NOTEBOOK')) {
    die('Прямой доступ запрещен');
}

/**
 * Формирует HTML-таблицу контактов и пагинацию.
 *
 * @param PDO $db Подключение к БД
 * @param string $sort Поле сортировки (id | surname | birthdate)
 * @param int $page Номер страницы (начиная с 1)
 * @return string HTML-код
 */
function renderViewer(PDO $db, string $sort, int $page): string {
    $allowedSort = ['id', 'surname', 'birthdate'];
    if (!in_array($sort, $allowedSort, true)) {
        $sort = 'id';
    }

    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    // Общее количество записей
    $total = (int) $db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $totalPages = (int) ceil($total / $perPage);
    if ($totalPages < 1) $totalPages = 1;
    if ($page > $totalPages) $page = $totalPages;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $perPage;

    // Получаем записи
    $stmt = $db->prepare("SELECT * FROM contacts ORDER BY {$sort} ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $html = '';

    if (empty($rows)) {
        $html .= '<p>Записная книжка пуста.</p>';
    } else {
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<th>№</th>';
        $html .= '<th>Фамилия</th>';
        $html .= '<th>Имя</th>';
        $html .= '<th>Отчество</th>';
        $html .= '<th>Пол</th>';
        $html .= '<th>Дата рождения</th>';
        $html .= '<th>Телефон</th>';
        $html .= '<th>Адрес</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Комментарий</th>';
        $html .= '</tr>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['surname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['lastname'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['gender'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['birthdate'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['phone'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['address'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['email'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['comment'] ?? '') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';
    }

    // Пагинация
    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i === $page) {
                $html .= '<span>' . $i . '</span>';
            } else {
                $html .= '<a href="index.php?page=view&sort=' . $sort . '&p=' . $i . '">' . $i . '</a>';
            }
        }
        $html .= '</div>';
    }

    return $html;
}
