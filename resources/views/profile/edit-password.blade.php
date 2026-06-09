@extends('dashboard') {{-- AGORA ESTENDE A DASHBOARD DIRETAMENTE --}}

@section('page-title', 'Meu Perfil - Alterar Senha') {{-- Define o título da página --}}

@section('main-content') {{-- INJETAR DENTRO DO main-content DO LAYOUT --}}
    <section class="form-section">
        <div class="form-container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('perfil.update.senha') }}" method="POST" class="form-profile">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="current_password">Senha Atual:</label>
                    <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                </div>

                <div class="form-group">
                    <label for="password">Nova Senha:</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Nova Senha:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-salvar">Salvar Nova Senha</button>
                    <a href="{{ route('dashboard') }}" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection
