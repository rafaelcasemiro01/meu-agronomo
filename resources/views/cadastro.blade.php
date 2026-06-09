<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agronomo - Cadastro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos básicos para o botão de login, ajuste conforme seu CSS */
        .login-button { /* Renomeei a classe para login-button */
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #777;
        }
    </style>
</head>

<body class="auth-body">
    <div class="container-cadastro">
        {{-- Link para a página de Login --}}
        <a href="{{ route('login') }}" class="login-button">
            <i class="fas fa-arrow-left"></i> Login {{-- Texto alterado para 'Login' --}}
        </a>

        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="logo-meu-agronomo">
            <h1>Meu Agrônomo</h1>
        </div>

        <h2>Cadastre-se</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Nome completo</label>
            <input type="text" name="name" id="name" required placeholder="Digite seu nome completo" value="{{ old('name') }}" autofocus>
            @error('name')
                <span style="color: #ffcccc; font-size: 0.8em;">{{ $message }}</span>
            @enderror

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Digite seu email" value="{{ old('email') }}">
            @error('email')
                <span style="color: #ffcccc; font-size: 0.8em;">{{ $message }}</span>
            @enderror

            <label for="data_nascimento">Data de nascimento</label>
            <input type="date" name="data_nascimento" id="data_nascimento" required value="{{ old('data_nascimento') }}">
            @error('data_nascimento')
                <span style="color: #ffcccc; font-size: 0.8em;">{{ $message }}</span>
            @enderror

            <label for="celular">Celular</label>
            <input type="tel" id="celular" name="celular" placeholder="(xx) xxxxx-xxxx" required value="{{ old('celular') }}">
            @error('celular')
                <span style="color: #ffcccc; font-size: 0.8em;">{{ $message }}</span>
            @enderror

            <label for="password">Senha</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            @error('password')
                <span style="color: #ffcccc; font-size: 0.8em;">{{ $message }}</span>
            @enderror

            <label for="password-confirm">Repita a senha</label>
            <input type="password" id="password-confirm" name="password_confirmation" placeholder="Digite sua senha novamente" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    {{-- Script para formatar celular em tempo real --}}
    <script>
        const celularInput = document.getElementById('celular');

        celularInput.addEventListener('input', function(e) {
            let numero = e.target.value.replace(/\D/g, '');

            if (numero.length > 11) {
                numero = numero.slice(0, 11);
            }

            if (numero.length > 10) {
                numero = numero.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (numero.length > 6) {
                numero = numero.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (numero.length > 2) {
                numero = numero.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            } else if (numero.length > 0) {
                numero = numero.replace(/(\d{0,2})/, '($1');
            }

            e.target.value = numero;
        });
    </script>
</body>

</html>
