<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agrônomo — Cadastro</title>
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
                Comece agora
                <strong>gratuitamente.</strong>
            </h2>
            <p>Crie sua conta em minutos e tenha controle total da sua operação no campo.</p>
        </div>

        <div class="auth-panel-left-footer">
            © {{ date('Y') }} Meu Agrônomo
        </div>
    </div>

    {{-- Painel direito —————————————————————————————— --}}
    <div class="auth-panel-right">
        <div class="auth-form-container" style="max-width: 400px;">

            <a href="{{ route('login') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Voltar ao login
            </a>

            <div class="auth-form-header">
                <h1>Criar conta</h1>
                <p>Preencha os dados abaixo para começar.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="auth-field">
                    <label for="name">Nome completo</label>
                    <input type="text" name="name" id="name" required placeholder="Seu nome completo" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required placeholder="seu@email.com" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="auth-field">
                        <label for="data_nascimento">Nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" required value="{{ old('data_nascimento') }}">
                        @error('data_nascimento')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="auth-field">
                        <label for="celular">Celular</label>
                        <input type="tel" id="celular" name="celular" placeholder="(xx) xxxxx-xxxx" required value="{{ old('celular') }}">
                        @error('celular')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="auth-field">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password-confirm">Confirmar senha</label>
                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="Repita a senha" required>
                </div>

                <button type="submit" class="btn-primary">Criar conta</button>
            </form>

        </div>
    </div>

    <script>
        const celularInput = document.getElementById('celular');
        celularInput.addEventListener('input', function(e) {
            let n = e.target.value.replace(/\D/g, '').slice(0, 11);
            if (n.length > 10) n = n.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            else if (n.length > 6) n = n.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            else if (n.length > 2) n = n.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            else if (n.length > 0) n = n.replace(/(\d{0,2})/, '($1');
            e.target.value = n;
        });
    </script>
</body>
</html>
