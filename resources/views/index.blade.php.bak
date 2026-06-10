<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Login</title>
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
            <div class="auth-mobile-mark">
                <svg viewBox="0 0 64 64" fill="none">
                    <path d="M32 50V37" stroke="currentColor" stroke-width="4.3" stroke-linecap="round"/>
                    <g transform="translate(32,38)">
                        <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="currentColor"/>
                        <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="currentColor"/>
                    </g>
                </svg>
            </div>
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
