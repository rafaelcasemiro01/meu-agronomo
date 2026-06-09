<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Entrar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">

    {{-- Painel esquerdo —————————————————————————————— --}}
    <div class="auth-panel-left">
        <div class="auth-brand">
            <div class="auth-brand-icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="22" x2="12" y2="10"/>
        <path d="M12 10 C12 10 8 7 8 4a4 4 0 0 1 8 0c0 3-4 6-4 6z"/>
        <path d="M12 14 C14 12 17 13 18 11"/>
        <path d="M12 14 C10 12 7 13 6 11"/>
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
