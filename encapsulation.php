<?php

/**
 * Задание: Инкапсуляция
 * Дополнить метод sayHello(), чтобы кошка после имени говорила о своём цвете.
 * Свойство color должно быть приватным, задаваться через конструктор, иметь геттер.
 */

class Cat
{
    private $name;
    private $color;

    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function sayHello(): void
    {
        echo 'Мяу! Меня зовут ' . $this->getName()
            . '. Я ' . $this->getColor() . ' цвета.' . PHP_EOL;
    }
}

// Создание объекта кошки и приветствие
$cat = new Cat('Мурка', 'чёрного');
$cat->sayHello();

// Демонстрация геттера
echo 'Цвет кошки: ' . $cat->getColor() . PHP_EOL;
