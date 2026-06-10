<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Criar conta</title>
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
            <div class="t-eyebrow" style="color:rgba(255,255,255,.7);margin-bottom:20px;">Comece agora</div>
            <h1 class="t-display" style="color:#fff;margin:0;">Crie sua conta<br>gratuitamente.</h1>
            <p>Configure em minutos e comece a organizar seus clientes e visitas técnicas hoje mesmo.</p>
        </div>

        <div class="auth-foot">© 2026 Meu Agrônomo</div>
    </div>

    {{-- Lado direito: formulário --}}
    <div class="auth-formside">
        <div class="auth-form-wrap">
            <button class="btn-back" onclick="window.location.href='{{ route('login') }}'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Voltar para o login
            </button>

            <div class="auth-mobile-mark">
                <svg viewBox="0 0 64 64" fill="none">
                    <path d="M32 50V37" stroke="currentColor" stroke-width="4.3" stroke-linecap="round"/>
                    <g transform="translate(32,38)">
                        <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="currentColor"/>
                        <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="currentColor"/>
                    </g>
                </svg>
            </div>

            <h2>Criar conta</h2>
            <p>Preencha seus dados para começar.</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="auth-field">
                    <label class="field-label">NOME COMPLETO</label>
                    <input class="input" type="text" name="name"
                           value="{{ old('name') }}" placeholder="Seu nome" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label class="field-label">E-MAIL</label>
                    <input class="input" type="email" name="email"
                           value="{{ old('email') }}" placeholder="seu@email.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label class="field-label">SENHA</label>
                    <input class="input" type="password" name="password" placeholder="Mín. 8 caracteres" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label class="field-label">CONFIRMAR SENHA</label>
                    <input class="input" type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit" style="margin-top:8px;">
                    Criar conta
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>

            <div class="auth-links">
                <span class="auth-link" style="font-size:12px;color:var(--text-mute);">
                    © 2026 Meu Agrônomo
                </span>
            </div>
        </div>
    </div>

</body>
</html>
