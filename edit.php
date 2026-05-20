<?php
if (!defined('NOTEBOOK')) {
    die('Прямой доступ запрещен');
}

/**
 * Форма редактирования записи со списком контактов.
 *
 * @param PDO $db Подключение к БД
 * @return string HTML-код
 */
function renderEdit(PDO $db): string {
    // Список контактов для выбора
    $contacts = $db->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC")->fetchAll();

    $currentId = isset($_GET['id']) ? (int) $_GET['id'] : null;
    if ($currentId === null && !empty($contacts)) {
        $currentId = (int) $contacts[0]['id'];
    }

    $message = '';

    // Обработка обновления
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
        $id = (int) ($_POST['id'] ?? 0);
        $surname = trim($_POST['surname'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $birthdate = trim($_POST['birthdate'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $comment = trim($_POST['comment'] ?? '');

        if ($surname !== '' && $name !== '' && $id > 0) {
            try {
                $stmt = $db->prepare("UPDATE contacts SET surname=:surname, name=:name, lastname=:lastname, gender=:gender, birthdate=:birthdate, phone=:phone, address=:address, email=:email, comment=:comment WHERE id=:id");
                $stmt->execute([
                    ':id' => $id,
                    ':surname' => $surname,
                    ':name' => $name,
                    ':lastname' => $lastname,
                    ':gender' => $gender,
                    ':birthdate' => $birthdate,
                    ':phone' => $phone,
                    ':address' => $address,
                    ':email' => $email,
                    ':comment' => $comment,
                ]);
                $message = '<div class="success">Запись обновлена</div>';
            } catch (PDOException $e) {
                $message = '<div class="error">Ошибка: запись не обновлена</div>';
            }
        } else {
            $message = '<div class="error">Ошибка: фамилия и имя обязательны</div>';
        }
    }

    $html = '';

    // Список ссылок
    if (!empty($contacts)) {
        $html .= '<ul class="list-links">';
        foreach ($contacts as $c) {
            $isCurrent = ((int) $c['id'] === $currentId);
            $class = $isCurrent ? 'currentRow' : '';
            $text = htmlspecialchars($c['surname'] . ' ' . $c['name'] . ' ' . ($c['lastname'] ?? ''));
            $html .= '<li><a href="index.php?page=edit&id=' . $c['id'] . '" class="' . $class . '">' . $text . '</a></li>';
        }
        $html .= '</ul>';
    } else {
        $html .= '<p>Нет записей для редактирования.</p>';
        return $html;
    }

    // Получаем текущую запись
    $row = null;
    if ($currentId > 0) {
        $stmt = $db->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->execute([':id' => $currentId]);
        $row = $stmt->fetch();
    }

    if (!$row) {
        $html .= '<p>Запись не найдена.</p>';
        return $html;
    }

    $html .= $message;
    $html .= '<form method="post">';
    $html .= '<input type="hidden" name="id" value="' . $row['id'] . '">';
    $html .= '<div class="column">';

    $fields = [
        'surname' => ['label' => 'Фамилия', 'type' => 'text'],
        'name' => ['label' => 'Имя', 'type' => 'text'],
        'lastname' => ['label' => 'Отчество', 'type' => 'text'],
        'gender' => ['label' => 'Пол', 'type' => 'select', 'options' => ['мужской', 'женский']],
        'birthdate' => ['label' => 'Дата рождения', 'type' => 'date'],
        'phone' => ['label' => 'Телефон', 'type' => 'text'],
        'address' => ['label' => 'Адрес', 'type' => 'text'],
        'email' => ['label' => 'Email', 'type' => 'email'],
        'comment' => ['label' => 'Комментарий', 'type' => 'textarea'],
    ];

    foreach ($fields as $fieldName => $field) {
        $value = $row[$fieldName] ?? '';
        $html .= '<div class="add">';
        $html .= '<label>' . htmlspecialchars($field['label']) . '</label>';

        if ($field['type'] === 'select') {
            $html .= '<select name="' . $fieldName . '">';
            foreach ($field['options'] as $opt) {
                $selected = ($value === $opt) ? 'selected' : '';
                $html .= '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
            }
            $html .= '</select>';
        } elseif ($field['type'] === 'textarea') {
            $html .= '<textarea name="' . $fieldName . '">' . htmlspecialchars($value) . '</textarea>';
        } else {
            $html .= '<input type="' . $field['type'] . '" name="' . $fieldName . '" value="' . htmlspecialchars($value) . '">';
        }

        $html .= '</div>';
    }

    $html .= '<button type="submit" name="button" value="Сохранить" class="form-btn">Сохранить</button>';
    $html .= '</div>';
    $html .= '</form>';

    return $html;
}
