<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Login</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='15' fill='%233f6553'/%3E%3Cpath d='M32 50V37' stroke='white' stroke-width='4.3' stroke-linecap='round'/%3E%3Cg transform='translate(32,38)'%3E%3Cpath transform='rotate(27)' d='M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z' fill='white'/%3E%3Cpath transform='rotate(-29) scale(0.9)' d='M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z' fill='white'/%3E%3C/g%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            var t = localStorage.getItem('ma_theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body class="auth-body">

    <style>
        .auth-theme-toggle { position: fixed; top: 18px; right: 18px; z-index: 50; width: 40px; height: 40px;
            display: grid; place-items: center; border-radius: 50%; border: 1px solid var(--border);
            background: var(--surface); color: var(--text-dim); cursor: pointer; transition: background .15s, color .15s; }
        .auth-theme-toggle:hover { background: var(--surface-2); color: var(--text); }
        .auth-theme-toggle svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
    </style>
    <button class="auth-theme-toggle" id="authThemeToggle" type="button" aria-label="Alternar tema claro/escuro">
        <svg id="authSun" style="display:none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg id="authMoon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
    </button>
    <script>
        (function () {
            var html = document.documentElement,
                btn  = document.getElementById('authThemeToggle'),
                sun  = document.getElementById('authSun'),
                moon = document.getElementById('authMoon');
            function apply(t) {
                html.setAttribute('data-theme', t);
                localStorage.setItem('ma_theme', t);
                sun.style.display  = t === 'dark' ? 'block' : 'none';
                moon.style.display = t === 'dark' ? 'none'  : 'block';
            }
            apply(localStorage.getItem('ma_theme') || 'light');
            btn.addEventListener('click', function () {
                apply(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
            });
        })();
    </script>


    {{-- Lado esquerdo: brand --}}
    <div class="auth-brandside">
        <div class="auth-brandtop">
            <div class="auth-brandtop__icon">
                <svg width="26" height="26" viewBox="0 0 64 64" fill="none">
                    <path d="M32 50V37" stroke="white" stroke-width="4.3" stroke-linecap="round"/>
                    <g transform="translate(32,38)">
                        <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                        <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                    </g>
                </svg>
            </div>
            <span class="auth-brandtop__name">Meu Agrônomo</span>
        </div>

        <div class="auth-pitch">
            <div class="t-eyebrow" style="color:rgba(255,255,255,.7);margin-bottom:20px;">Gestão agrícola</div>
            <h1 class="t-display" style="color:#fff;margin:0;">O campo,<br>em ordem.</h1>
            <p>O espaço onde o agrônomo organiza clientes, visitas e resultados — com a calma de quem está no controle.</p>
            <ul class="auth-pitch__points">
                <li>
                    <span class="auth-pitch__check">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </span>
                    Cadastre clientes e propriedades em segundos
                </li>
                <li>
                    <span class="auth-pitch__check">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </span>
                    Agende visitas técnicas sem planilhas
                </li>
                <li>
                    <span class="auth-pitch__check">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </span>
                    Relatórios de campo organizados em um só lugar
                </li>
            </ul>
        </div>

        <div class="auth-foot">© 2026 Meu Agrônomo</div>
    </div>

    {{-- Lado direito: formulário --}}
    <div class="auth-formside">
        <div class="auth-form-wrap">
            <h2>Bem-vindo de volta</h2>
            <p>Entre com suas credenciais para continuar.</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="auth-field">
                    <label class="field-label">E-MAIL</label>
                    <input class="input" type="email" name="email"
                           value="{{ old('email') }}" placeholder="seu@email.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:7px;">
                        <label class="field-label" style="margin-bottom:0;">SENHA</label>
                        @if (Route::has('password.request'))
                            <a class="auth-link" href="{{ route('password.request') }}" style="font-size:12.5px;">Esqueceu?</a>
                        @endif
                    </div>
                    <input class="input" type="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit" style="margin-top:8px;">
                    Entrar
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>

            <div class="auth-links">
                @if (Route::has('register'))
                    <a class="auth-link-cta" href="{{ route('register') }}">Criar conta gratuita</a>
                @endif
                <span class="auth-link" style="font-size:12px;color:var(--text-mute);">
                    © 2026 Meu Agrônomo
                </span>
            </div>
        </div>
    </div>

</body>
</html>
