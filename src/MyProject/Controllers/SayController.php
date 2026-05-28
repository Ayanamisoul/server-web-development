<?php

namespace MyProject\Controllers;

class SayController
{
    public function sayHello(string $name): void
    {
        $pageTitle = 'Страница приветствия';
        $contentFile = __DIR__ . '/../../../hello_content.php';
        require __DIR__ . '/../../../layout.php';
    }

    public function sayBye(string $name): void
    {
        $pageTitle = 'Прощание';
        $contentFile = __DIR__ . '/../../../bye_content.php';
        require __DIR__ . '/../../../layout.php';
    }
}
