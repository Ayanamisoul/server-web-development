<?php

/**
 * Контроллер для приветствий и прощаний
 */
class SayController
{
    /**
     * Выводит приветствие
     */
    public function sayHello(string $name): void
    {
        echo "Привет, $name";
    }

    /**
     * Выводит прощание
     */
    public function sayBye(string $name): void
    {
        echo "Пока, $name";
    }
}
