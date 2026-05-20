<?php
require_once 'lib/Calculator.php';

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['expression'])) {
    header('Location: index.php');
    exit;
}

$expression = trim($_POST['expression']);

if ($expression === '') {
    header('Location: index.php?error=' . urlencode('Введите выражение'));
    exit;
}

$calc = new Calculator();
try {
    $result = $calc->calculate($expression);
    // Форматируем результат: если целое - без .0
    if (floor($result) == $result && !is_infinite($result)) {
        $resultStr = number_format($result, 0, '', '');
    } else {
        $resultStr = (string) $result;
    }
    header('Location: index.php?result=' . urlencode($resultStr) . '&expression=' . urlencode($expression));
    exit;
} catch (Exception $e) {
    header('Location: index.php?error=' . urlencode($e->getMessage()) . '&expression=' . urlencode($expression));
    exit;
}
