<?php
if (!defined('NOTEBOOK')) {
    die('Прямой доступ запрещен');
}

/**
 * Удаление записи из базы данных.
 *
 * @param PDO $db Подключение к БД
 * @return string HTML-код
 */
function renderDelete(PDO $db): string {
    $message = '';

    // Удаление
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $stmt = $db->prepare("SELECT surname FROM contacts WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            try {
                $db->prepare("DELETE FROM contacts WHERE id = :id")->execute([':id' => $id]);
                $message = '<div class="success">Запись с фамилией ' . htmlspecialchars($row['surname']) . ' удалена</div>';
            } catch (PDOException $e) {
                $message = '<div class="error">Ошибка при удалении записи</div>';
            }
        } else {
            $message = '<div class="error">Запись не найдена</div>';
        }
    }

    // Список контактов
    $contacts = $db->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC")->fetchAll();

    $html = $message;

    if (!empty($contacts)) {
        $html .= '<ul class="list-links">';
        foreach ($contacts as $c) {
            $initials = mb_substr($c['name'], 0, 1) . '.';
            if (!empty($c['lastname'])) {
                $initials .= mb_substr($c['lastname'], 0, 1) . '.';
            }
            $text = htmlspecialchars($c['surname'] . ' ' . $initials);
            $html .= '<li><a href="index.php?page=delete&id=' . $c['id'] . '">' . $text . '</a></li>';
        }
        $html .= '</ul>';
    } else {
        $html .= '<p>Нет записей для удаления.</p>';
    }

    return $html;
}
