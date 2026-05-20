const display = document.getElementById('display');
const form = document.getElementById('calc-form');

function appendValue(val) {
    const start = display.selectionStart;
    const end = display.selectionEnd;
    const text = display.value;
    display.value = text.slice(0, start) + val + text.slice(end);
    display.focus();
    display.setSelectionRange(start + val.length, start + val.length);
}

function clearDisplay() {
    display.value = '';
    display.focus();
}

function backspace() {
    const start = display.selectionStart;
    const end = display.selectionEnd;
    const text = display.value;

    if (start === end && start > 0) {
        // Удаляем один символ перед курсором
        display.value = text.slice(0, start - 1) + text.slice(end);
        display.focus();
        display.setSelectionRange(start - 1, start - 1);
    } else if (start !== end) {
        // Удаляем выделенный текст
        display.value = text.slice(0, start) + text.slice(end);
        display.focus();
        display.setSelectionRange(start, start);
    }
}

// Поддержка клавиатуры
display.addEventListener('keydown', function(e) {
    // Enter отправляет форму
    if (e.key === 'Enter') {
        e.preventDefault();
        form.submit();
        return;
    }

    // Разрешенные символы
    const allowedKeys = [
        '0','1','2','3','4','5','6','7','8','9',
        '+','-','*','/','^','!','.','(',')',
        'Backspace','Delete','ArrowLeft','ArrowRight','Home','End','Tab'
    ];

    // Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
    if (e.ctrlKey && ['a','c','v','x'].includes(e.key.toLowerCase())) {
        return;
    }

    if (!allowedKeys.includes(e.key)) {
        e.preventDefault();
    }
});

// Фокус на дисплей при загрузке
window.addEventListener('DOMContentLoaded', () => {
    display.focus();
});
