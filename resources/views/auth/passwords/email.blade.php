<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Recuperar senha</title>
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
            <div class="t-eyebrow" style="color:rgba(255,255,255,.7);margin-bottom:20px;">Recuperação de acesso</div>
            <h1 class="t-display" style="color:#fff;margin:0;">Esqueceu<br>a senha?</h1>
            <p>Sem problema. Informe seu e-mail e enviaremos um link para você criar uma nova senha.</p>
        </div>

        <div class="auth-foot">© 2026 Meu Agrônomo</div>
    </div>

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

            <h2>Recuperar senha</h2>
            <p>Enviaremos um link de redefinição para o seu e-mail.</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="auth-field">
                    <label class="field-label">E-MAIL</label>
                    <input class="input" type="email" name="email" value="{{ old('email') }}"
                           placeholder="seu@email.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback" style="color:var(--danger,#c0392b);font-size:13px;margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit" style="margin-top:8px;">
                    Enviar link de redefinição
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>

            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-link-cta">Lembrei minha senha — entrar</a>
            </div>
        </div>
    </div>

</body>
</html>
