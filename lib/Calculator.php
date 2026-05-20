<?php
/**
 * Рекурсивный калькулятор математических выражений.
 * Поддерживает: +, -, *, /, ^, sqrt, ln, log, !, pi, e, скобки, унарный минус, дробные числа.
 */
class Calculator {
    private string $expr = '';
    private int $pos = 0;
    private int $len = 0;

    /**
     * Основной метод вычисления.
     */
    public function calculate(string $expression): float {
        $this->expr = str_replace(' ', '', $expression);
        $this->len = strlen($this->expr);
        $this->pos = 0;

        if ($this->len === 0) {
            throw new Exception("Выражение пустое");
        }

        $this->validateBrackets();

        $result = $this->parseExpression();

        if ($this->pos < $this->len) {
            throw new Exception("Некорректное выражение на позиции " . ($this->pos + 1));
        }

        return $result;
    }

    /* ---------- Рекурсивный спуск ---------- */

    // expression = term { ('+' | '-') term }
    private function parseExpression(): float {
        $value = $this->parseTerm();
        while (true) {
            if ($this->match('+')) {
                $value += $this->parseTerm();
            } elseif ($this->match('-')) {
                $value -= $this->parseTerm();
            } else {
                break;
            }
        }
        return $value;
    }

    // term = power { ('*' | '/') power }
    private function parseTerm(): float {
        $value = $this->parsePower();
        while (true) {
            if ($this->match('*')) {
                $value *= $this->parsePower();
            } elseif ($this->match('/')) {
                $divisor = $this->parsePower();
                if ($divisor == 0) {
                    throw new Exception("Деление на ноль");
                }
                $value /= $divisor;
            } else {
                break;
            }
        }
        return $value;
    }

    // power = unary [ '^' power ]   (правая ассоциативность)
    private function parsePower(): float {
        $value = $this->parseUnary();
        if ($this->match('^')) {
            $exponent = $this->parsePower(); // рекурсия для правой ассоциативности
            $value = pow($value, $exponent);
        }
        return $value;
    }

    // unary = ('+' | '-') unary | postfix
    private function parseUnary(): float {
        if ($this->match('+')) {
            return $this->parseUnary();
        }
        if ($this->match('-')) {
            return -$this->parseUnary();
        }
        return $this->parsePostfix();
    }

    // postfix = primary [ '!' ]
    private function parsePostfix(): float {
        $value = $this->parsePrimary();
        if ($this->match('!')) {
            $value = $this->factorial($value);
        }
        return $value;
    }

    // primary = number | '(' expression ')' | constant | function
    private function parsePrimary(): float {
        // Число (целое или дробное)
        if ($this->isDigit() || $this->peek() === '.') {
            return $this->parseNumber();
        }

        // Скобки
        if ($this->match('(')) {
            $value = $this->parseExpression();
            if (!$this->match(')')) {
                throw new Exception("Ожидается закрывающая скобка ')'");
            }
            return $value;
        }

        // Константы и функции
        if ($this->matchConstant('pi')) {
            return M_PI;
        }
        if ($this->matchConstant('e')) {
            return M_E;
        }
        if ($this->matchString('sqrt(')) {
            $arg = $this->parseExpression();
            if (!$this->match(')')) throw new Exception("Ожидается ')' после sqrt");
            if ($arg < 0) throw new Exception("Корень из отрицательного числа");
            return sqrt($arg);
        }
        if ($this->matchString('ln(')) {
            $arg = $this->parseExpression();
            if (!$this->match(')')) throw new Exception("Ожидается ')' после ln");
            if ($arg <= 0) throw new Exception("ln определен только для x > 0");
            return log($arg);
        }
        if ($this->matchString('log(')) {
            $arg = $this->parseExpression();
            if (!$this->match(')')) throw new Exception("Ожидается ')' после log");
            if ($arg <= 0) throw new Exception("log определен только для x > 0");
            return log10($arg);
        }

        throw new Exception("Неожиданный символ '" . $this->peek() . "' на позиции " . ($this->pos + 1));
    }

    /* ---------- Вспомогательные методы ---------- */

    private function parseNumber(): float {
        $start = $this->pos;
        $hasDot = false;
        while ($this->pos < $this->len && ($this->isDigit() || $this->peek() === '.')) {
            if ($this->peek() === '.') {
                if ($hasDot) break; // вторая точка
                $hasDot = true;
            }
            $this->pos++;
        }
        $numStr = substr($this->expr, $start, $this->pos - $start);
        if ($numStr === '.' || $numStr === '') {
            throw new Exception("Некорректное число");
        }
        return floatval($numStr);
    }

    private function factorial(float $n): float {
        if ($n < 0 || floor($n) != $n) {
            throw new Exception("Факториал определен только для неотрицательных целых чисел");
        }
        if ($n > 170) {
            throw new Exception("Факториал слишком большой");
        }
        $result = 1;
        for ($i = 2; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }

    private function peek(): string {
        if ($this->pos >= $this->len) return "\0";
        return $this->expr[$this->pos];
    }

    private function isDigit(): bool {
        $c = $this->peek();
        return $c >= '0' && $c <= '9';
    }

    private function match(string $char): bool {
        if ($this->peek() === $char) {
            $this->pos++;
            return true;
        }
        return false;
    }

    private function matchString(string $str): bool {
        $len = strlen($str);
        if (substr($this->expr, $this->pos, $len) === $str) {
            $this->pos += $len;
            return true;
        }
        return false;
    }

    private function matchConstant(string $str): bool {
        $len = strlen($str);
        if (substr($this->expr, $this->pos, $len) === $str) {
            // Проверяем, что после константы не идет буква (чтобы e не съело exp)
            $nextPos = $this->pos + $len;
            if ($nextPos < $this->len) {
                $nextChar = $this->expr[$nextPos];
                if (ctype_alpha($nextChar)) {
                    return false;
                }
            }
            $this->pos += $len;
            return true;
        }
        return false;
    }

    /* ---------- Валидация ---------- */

    private function validateCharacters(): void {
        $allowed = '/^[0-9+\-*\/^!.()pielogqrt\s]+$/';
        if (!preg_match($allowed, $this->expr)) {
            throw new Exception("Выражение содержит недопустимые символы");
        }
    }

    private function validateBrackets(): void {
        $balance = 0;
        for ($i = 0; $i < $this->len; $i++) {
            if ($this->expr[$i] === '(') $balance++;
            if ($this->expr[$i] === ')') $balance--;
            if ($balance < 0) {
                throw new Exception("Несбалансированные скобки");
            }
        }
        if ($balance !== 0) {
            throw new Exception("Несбалансированные скобки");
        }
    }
}
