<?php
/**
 * Универсальный решатель простых линейных уравнений с одним действием.
 * Поддерживает форматы: X+a=b, X-a=b, X*a=b, X/a=b, a+X=b, a-X=b, a*X=b, a/X=b,
 * а также когда X находится в правой части.
 */
class EquationSolver {
    public string $equation = '';
    public ?string $operator = null;
    public string $xSide = '';      // 'left' или 'right'
    public string $xPosition = '';  // 'operand1' или 'operand2'
    public float $result = 0;
    public string $solutionSteps = '';

    /**
     * Решает уравнение.
     */
    public function solve(string $eq): float {
        // 1. Нормализация: удаляем пробелы, приводим x к верхнему регистру
        $eq = strtoupper(str_replace(' ', '', $eq));
        $this->equation = $eq;

        // 2. Разделяем по '='
        if (strpos($eq, '=') === false) {
            throw new Exception("В уравнении отсутствует знак '='");
        }
        list($leftRaw, $rightRaw) = explode('=', $eq, 2);

        // 3. Ищем оператор и определяем, в какой части уравнения он находится
        $ops = ['+', '-', '*', '/'];
        $side = 'left';
        $expression = $leftRaw;
        $constantSide = $rightRaw;
        $op = null;
        $opPos = false;

        foreach ($ops as $o) {
            $pos = strpos($expression, $o);
            if ($pos !== false && $pos > 0) {
                $op = $o;
                $opPos = $pos;
                break;
            }
        }

        // Если оператор не найден слева, ищем справа
        if ($op === null) {
            $side = 'right';
            $expression = $rightRaw;
            $constantSide = $leftRaw;
            foreach ($ops as $o) {
                $pos = strpos($expression, $o);
                if ($pos !== false && $pos > 0) {
                    $op = $o;
                    $opPos = $pos;
                    break;
                }
            }
        }

        if ($op === null) {
            throw new Exception("Не удалось определить оператор (+, -, *, /)");
        }

        $this->operator = $this->getOperatorName($op);

        // 4. Операнды выражения
        $operand1 = substr($expression, 0, $opPos);
        $operand2 = substr($expression, $opPos + 1);

        // 5. Определяем расположение X
        $xInOp1 = $this->containsX($operand1);
        $xInOp2 = $this->containsX($operand2);
        $xInConst = $this->containsX($constantSide);

        $a = floatval($operand1);
        $b = floatval($operand2);
        $c = floatval($constantSide);

        // 6. Решение
        if ($side === 'left') {
            $this->xSide = 'left';
            if ($xInOp1) {
                $this->xPosition = 'operand1';
                // X op b = c
                switch ($op) {
                    case '+': $this->result = $c - $b; $this->solutionSteps = "X = $c - $b"; break;
                    case '-': $this->result = $c + $b; $this->solutionSteps = "X = $c + $b"; break;
                    case '*': $this->result = $c / $b; $this->solutionSteps = "X = $c / $b"; break;
                    case '/': $this->result = $c * $b; $this->solutionSteps = "X = $c * $b"; break;
                }
            } elseif ($xInOp2) {
                $this->xPosition = 'operand2';
                // a op X = c
                switch ($op) {
                    case '+': $this->result = $c - $a; $this->solutionSteps = "X = $c - $a"; break;
                    case '-': $this->result = $a - $c; $this->solutionSteps = "X = $a - $c"; break;
                    case '*': $this->result = $c / $a; $this->solutionSteps = "X = $c / $a"; break;
                    case '/': $this->result = $a / $c; $this->solutionSteps = "X = $a / $c"; break;
                }
            } else {
                throw new Exception("Неизвестная переменная X не найдена в левой части");
            }
        } else {
            $this->xSide = 'right';
            if ($xInOp1) {
                $this->xPosition = 'operand1';
                // c = X op b
                switch ($op) {
                    case '+': $this->result = $c - $b; $this->solutionSteps = "X = $c - $b"; break;
                    case '-': $this->result = $c + $b; $this->solutionSteps = "X = $c + $b"; break;
                    case '*': $this->result = $c / $b; $this->solutionSteps = "X = $c / $b"; break;
                    case '/': $this->result = $c * $b; $this->solutionSteps = "X = $c * $b"; break;
                }
            } elseif ($xInOp2) {
                $this->xPosition = 'operand2';
                // c = a op X
                switch ($op) {
                    case '+': $this->result = $c - $a; $this->solutionSteps = "X = $c - $a"; break;
                    case '-': $this->result = $a - $c; $this->solutionSteps = "X = $a - $c"; break;
                    case '*': $this->result = $c / $a; $this->solutionSteps = "X = $c / $a"; break;
                    case '/': $this->result = $a / $c; $this->solutionSteps = "X = $a / $c"; break;
                }
            } else {
                throw new Exception("Неизвестная переменная X не найдена в правой части");
            }
        }

        return $this->result;
    }

    private function containsX(string $str): bool {
        return strpos($str, 'X') !== false;
    }

    private function getOperatorName(string $op): string {
        return match ($op) {
            '+' => 'сложение (+)',
            '-' => 'вычитание (-)',
            '*' => 'умножение (*)',
            '/' => 'деление (/)',
            default => $op,
        };
    }

    public function getXPositionDescription(): string {
        $side = $this->xSide === 'left' ? 'левая часть' : 'правая часть';
        $pos = $this->xPosition === 'operand1' ? 'первый операнд' : 'второй операнд';
        return "$side, $pos";
    }
}
