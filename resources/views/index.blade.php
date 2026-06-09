<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Agronomo - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-body">
    <div class="container-login">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="logo-meu-agronomo">
            <h1>Meu Agrônomo</h1>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Digite seu email" value="{{ old('email') }}" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="password">Senha</label>
            <input type="password" name="password" id="senha" required placeholder="Digite sua senha">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="submit">Entrar</button>
        </form>

        <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
        <br>

        <a href="{{ route('register') }}" class="btn-p-acesso">Primeiro acesso? Cadastre-se</a>
    </div>
</body>

</html>
