<?php
if (!defined('NOTEBOOK')) {
    die('Прямой доступ запрещен');
}

/**
 * Форма добавления записи и её обработка.
 *
 * @param PDO $db Подключение к БД
 * @return string HTML-код
 */
function renderAdd(PDO $db): string {
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
        $surname = trim($_POST['surname'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $birthdate = trim($_POST['birthdate'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $comment = trim($_POST['comment'] ?? '');

        if ($surname !== '' && $name !== '') {
            try {
                $stmt = $db->prepare("INSERT INTO contacts (surname, name, lastname, gender, birthdate, phone, address, email, comment) VALUES (:surname, :name, :lastname, :gender, :birthdate, :phone, :address, :email, :comment)");
                $stmt->execute([
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
                $message = '<div class="success">Запись добавлена</div>';
            } catch (PDOException $e) {
                $message = '<div class="error">Ошибка: запись не добавлена</div>';
            }
        } else {
            $message = '<div class="error">Ошибка: фамилия и имя обязательны</div>';
        }
    }

    $html = $message;
    $html .= '<form method="post">';
    $html .= '<div class="column">';

    $fields = [
        'surname' => ['label' => 'Фамилия', 'type' => 'text', 'placeholder' => 'Фамилия'],
        'name' => ['label' => 'Имя', 'type' => 'text', 'placeholder' => 'Имя'],
        'lastname' => ['label' => 'Отчество', 'type' => 'text', 'placeholder' => 'Отчество'],
        'gender' => ['label' => 'Пол', 'type' => 'select', 'options' => ['мужской', 'женский']],
        'birthdate' => ['label' => 'Дата рождения', 'type' => 'date'],
        'phone' => ['label' => 'Телефон', 'type' => 'text', 'placeholder' => 'Телефон'],
        'address' => ['label' => 'Адрес', 'type' => 'text', 'placeholder' => 'Адрес'],
        'email' => ['label' => 'Email', 'type' => 'email', 'placeholder' => 'Email'],
        'comment' => ['label' => 'Комментарий', 'type' => 'textarea', 'placeholder' => 'Краткий комментарий'],
    ];

    foreach ($fields as $fieldName => $field) {
        $html .= '<div class="add">';
        $html .= '<label>' . htmlspecialchars($field['label']) . '</label>';

        if ($field['type'] === 'select') {
            $html .= '<select name="' . $fieldName . '">';
            foreach ($field['options'] as $opt) {
                $html .= '<option value="' . $opt . '">' . $opt . '</option>';
            }
            $html .= '</select>';
        } elseif ($field['type'] === 'textarea') {
            $html .= '<textarea name="' . $fieldName . '" placeholder="' . ($field['placeholder'] ?? '') . '"></textarea>';
        } else {
            $html .= '<input type="' . $field['type'] . '" name="' . $fieldName . '" placeholder="' . ($field['placeholder'] ?? '') . '">';
        }

        $html .= '</div>';
    }

    $html .= '<button type="submit" name="button" value="Добавить" class="form-btn">Добавить</button>';
    $html .= '</div>';
    $html .= '</form>';

    return $html;
}
