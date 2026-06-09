@extends('dashboard') {{-- ESTENDE A DASHBOARD DIRETAMENTE --}}

@section('page-title', 'Meu Perfil - Informações Pessoais') {{-- Define o título da página --}}

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

            <form action="{{ route('perfil.update.info') }}" method="POST" class="form-profile">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                </div>

                {{-- Campo Celular --}}
                <div class="form-group">
                    <label for="celular">Celular:</label>
                    <input type="tel" id="celular" name="celular" value="{{ old('celular', $user->celular) }}" autocomplete="tel" placeholder="(00) 00000-0000">
                </div>

                {{-- Campo Data de Nascimento --}}
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $user->data_nascimento ? $user->data_nascimento->format('Y-m-d') : '') }}" autocomplete="bday">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-salvar">Salvar Alterações</button>
                    <a href="{{ route('dashboard') }}" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </section>

    {{-- Script para formatar celular em tempo real --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const celularInput = document.getElementById('celular');

            if (celularInput) {
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
            }
        });
    </script>
@endsection
