<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Budget Personnel — Accès sécurisé</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0F172A;
            font-family: 'Inter', sans-serif;
        }
        .lock-card {
            background: #1E293B;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 40px 32px;
            width: 100%;
            max-width: 360px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }
        .lock-icon {
            width: 64px;
            height: 64px;
            background: rgba(0,174,239,0.12);
            border: 1px solid rgba(0,174,239,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
        }
        .lock-title {
            color: #F8FAFC;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 6px;
        }
        .lock-sub {
            color: #94A3B8;
            font-size: 13px;
            margin: 0 0 28px;
        }
        /* PIN display */
        .pin-display {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .pin-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.2);
            transition: background 0.15s, border-color 0.15s;
        }
        .pin-dot.filled {
            background: #00AEEF;
            border-color: #00AEEF;
        }
        /* PIN pad */
        .pin-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }
        .pin-btn {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: #F1F5F9;
            font-size: 20px;
            font-weight: 600;
            padding: 16px;
            cursor: pointer;
            transition: background 0.12s, transform 0.08s;
            -webkit-tap-highlight-color: transparent;
        }
        .pin-btn:hover { background: rgba(255,255,255,0.1); }
        .pin-btn:active { transform: scale(0.94); background: rgba(0,174,239,0.2); }
        .pin-btn.del { font-size: 16px; color: #94A3B8; }
        .pin-btn.empty { cursor: default; background: transparent; border-color: transparent; }
        .pin-error {
            color: #EF4444;
            font-size: 12px;
            margin-top: 12px;
            min-height: 20px;
        }
        /* hidden real input */
        #pinInput { display: none; }
    </style>
</head>
<body>
<div class="lock-card">
    <div class="lock-icon">🔐</div>
    <h1 class="lock-title">Budget Personnel</h1>
    <p class="lock-sub">Entrez votre code PIN pour continuer</p>

    {{-- PIN dots --}}
    <div class="pin-display" id="pinDisplay">
        <div class="pin-dot" id="dot0"></div>
        <div class="pin-dot" id="dot1"></div>
        <div class="pin-dot" id="dot2"></div>
        <div class="pin-dot" id="dot3"></div>
    </div>

    {{-- Error --}}
    <div class="pin-error" id="pinError">
        @error('pin') {{ $message }} @enderror
    </div>

    {{-- Hidden form --}}
    <form method="POST" action="{{ route('admin.budget.unlock') }}" id="pinForm">
        @csrf
        <input type="hidden" name="pin" id="pinInput" />
    </form>

    {{-- Keypad --}}
    <div class="pin-grid">
        @foreach(['1','2','3','4','5','6','7','8','9'] as $d)
        <button type="button" class="pin-btn" onclick="pressKey('{{ $d }}')">{{ $d }}</button>
        @endforeach
        <button type="button" class="pin-btn empty"></button>
        <button type="button" class="pin-btn" onclick="pressKey('0')">0</button>
        <button type="button" class="pin-btn del" onclick="deleteKey()">⌫</button>
    </div>
</div>

<script>
let pinValue = '';

function pressKey(digit) {
    if (pinValue.length >= 4) return;
    pinValue += digit;
    updateDots();
    if (pinValue.length === 4) {
        document.getElementById('pinInput').value = pinValue;
        setTimeout(() => document.getElementById('pinForm').submit(), 150);
    }
}

function deleteKey() {
    if (!pinValue.length) return;
    pinValue = pinValue.slice(0, -1);
    updateDots();
}

function updateDots() {
    for (let i = 0; i < 4; i++) {
        const dot = document.getElementById('dot' + i);
        dot.classList.toggle('filled', i < pinValue.length);
    }
}

// Keyboard support
document.addEventListener('keydown', function(e) {
    if (e.key >= '0' && e.key <= '9') pressKey(e.key);
    if (e.key === 'Backspace') deleteKey();
});
</script>
</body>
</html>
