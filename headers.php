<?php
$headers = get_headers("https://httpbin.org/get");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Headers</title>
    <style>
        body { margin: 0; font-family: Arial; display: flex; flex-direction: column; min-height: 100vh; }
        header, footer { background: #bbb; color: white; padding: 10px; }
        header { display: flex; align-items: center; }
        header img { height: 50px; }
        header h1 { flex-grow: 1; text-align: center; margin: 0; }

        main { flex: 1; padding: 20px; text-align: center; }

        textarea { width: 80%; height: 300px; }

        footer { text-align: center; background: #eee; color: black; }
    </style>
</head>
<body>

<header>
    <img src="src/Logo_Polytech_rus_main.jpg">
    <h1>Headers</h1>
</header>

<main>
    <textarea readonly>
<?php
foreach ($headers as $h) {
    echo $h . "\n";
}
?>
    </textarea>
</main>

<footer>
    задание для самостоятельной работы
</footer>

</body>
</html>