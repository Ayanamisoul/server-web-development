<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор — Lab 2.2</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="calc-wrapper">
        <h1>Калькулятор</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="message error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['result'])): ?>
            <div class="message success">Результат вычисления</div>
        <?php endif; ?>

        <form id="calc-form" action="calculate.php" method="POST">
            <div class="display-wrap">
                <input
                    type="text"
                    name="expression"
                    id="display"
                    placeholder="0"
                    autocomplete="off"
                    value="<?= isset($_GET['result']) ? htmlspecialchars($_GET['result']) : (isset($_GET['expression']) ? htmlspecialchars($_GET['expression']) : '') ?>"
                >
                <?php if (isset($_GET['expression']) && isset($_GET['result'])): ?>
                    <div class="history"><?= htmlspecialchars($_GET['expression']) ?> =</div>
                <?php endif; ?>
            </div>

            <div class="buttons">
                <!-- Ряд 1 -->
                <button type="button" class="btn func" onclick="appendValue('sqrt(')">√</button>
                <button type="button" class="btn func" onclick="appendValue('^')">^</button>
                <button type="button" class="btn func" onclick="appendValue('!')">!</button>
                <button type="button" class="btn action" onclick="clearDisplay()">C</button>

                <!-- Ряд 2 -->
                <button type="button" class="btn func" onclick="appendValue('ln(')">ln</button>
                <button type="button" class="btn func" onclick="appendValue('log(')">log</button>
                <button type="button" class="btn func" onclick="appendValue('pi')">π</button>
                <button type="button" class="btn func" onclick="appendValue('e')">e</button>

                <!-- Ряд 3 -->
                <button type="button" class="btn" onclick="appendValue('7')">7</button>
                <button type="button" class="btn" onclick="appendValue('8')">8</button>
                <button type="button" class="btn" onclick="appendValue('9')">9</button>
                <button type="button" class="btn op" onclick="appendValue('/')">÷</button>

                <!-- Ряд 4 -->
                <button type="button" class="btn" onclick="appendValue('4')">4</button>
                <button type="button" class="btn" onclick="appendValue('5')">5</button>
                <button type="button" class="btn" onclick="appendValue('6')">6</button>
                <button type="button" class="btn op" onclick="appendValue('*')">×</button>

                <!-- Ряд 5 -->
                <button type="button" class="btn" onclick="appendValue('1')">1</button>
                <button type="button" class="btn" onclick="appendValue('2')">2</button>
                <button type="button" class="btn" onclick="appendValue('3')">3</button>
                <button type="button" class="btn op" onclick="appendValue('-')">−</button>

                <!-- Ряд 6 -->
                <button type="button" class="btn" onclick="appendValue('0')">0</button>
                <button type="button" class="btn" onclick="appendValue('.')">.</button>
                <button type="button" class="btn op" onclick="appendValue('(')">(</button>
                <button type="button" class="btn op" onclick="appendValue(')')">)</button>

                <!-- Ряд 7 -->
                <button type="button" class="btn op" onclick="appendValue('+')">+</button>
                <button type="button" class="btn back" onclick="backspace()">←</button>
                <button type="submit" class="btn equal">=</button>
            </div>
        </form>

        <div class="hint">
            <p>Можно вводить выражение с клавиатуры. Доступны: + − × ÷ ^ √ ! ln log π e скобки</p>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
