<?php

/**
 * Задание: Интерфейсы в PHP
 * Использовать функцию get_class().
 * Для объектов, для которых считается площадь, выводить имя класса.
 * Для объектов, не реализующих интерфейс CalculateSquare, выводить соответствующее сообщение.
 */

interface CalculateSquare
{
    public function calculateSquare(): float;
}

class Circle implements CalculateSquare
{
    private $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSquare(): float
    {
        return pi() * $this->radius ** 2;
    }
}

class Rectangle implements CalculateSquare
{
    private $width;
    private $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateSquare(): float
    {
        return $this->width * $this->height;
    }
}

class Student
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

// Функция для вывода информации о площади объекта
function printSquareInfo($object): void
{
    $className = get_class($object);

    if ($object instanceof CalculateSquare) {
        echo 'Объект класса ' . $className
            . '. Площадь: ' . $object->calculateSquare() . PHP_EOL;
    } else {
        echo 'Объект класса ' . $className
            . ' не реализует интерфейс CalculateSquare.' . PHP_EOL;
    }
}

// Создание объектов и проверка
$circle = new Circle(5);
$rectangle = new Rectangle(4, 6);
$student = new Student('Иван');

printSquareInfo($circle);
printSquareInfo($rectangle);
printSquareInfo($student);
