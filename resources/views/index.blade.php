<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Entrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">

    {{-- Painel esquerdo —————————————————————————————— --}}
    <div class="auth-panel-left">
        <div class="auth-brand">
            <div class="auth-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22V12"/>
                    <path d="M12 12C12 12 7 9 7 5a5 5 0 0 1 10 0c0 4-5 7-5 7z"/>
                    <path d="M12 12c0 0 4-2 6 1"/>
                    <path d="M12 12c0 0-4-2-6 1"/>
                </svg>
            </div>
            <span class="auth-brand-name">Meu Agrônomo</span>
        </div>

        <div class="auth-panel-left-content">
            <h2>
                Gestão agrícola
                <strong>simples e eficiente.</strong>
            </h2>
            <p>Gerencie clientes, agende visitas técnicas e acompanhe seu trabalho em campo em um só lugar.</p>
        </div>

        <div class="auth-panel-left-footer">
            © {{ date('Y') }} Meu Agrônomo
        </div>
    </div>

    {{-- Painel direito —————————————————————————————— --}}
    <div class="auth-panel-right">
        <div class="auth-form-container">

            <div class="auth-form-header">
                <h1>Bem-vindo</h1>
                <p>Entre com suas credenciais para continuar.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-field">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="seu@email.com"
                        value="{{ old('email') }}"
                        autofocus
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="••••••••"
                    >
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">Entrar</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('password.request') }}" class="auth-link">Esqueceu sua senha?</a>
                <a href="{{ route('register') }}" class="auth-link-cta">Primeiro acesso? Cadastre-se</a>
            </div>

        </div>
    </div>

</body>
</html>
