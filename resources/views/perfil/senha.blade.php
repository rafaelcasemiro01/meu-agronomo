{{--
    PERFIL — ALTERAR SENHA
    Rota: perfil.senha (GET)  ·  Envia para: perfil.senha.atualizar (PUT)  [ajuste o nome se diferente]
--}}
@extends('dashboard')
@section('page-title', 'Alterar senha — Meu Agrônomo')
@section('topbar-title', 'Alterar senha')

@section('main-content')
<div class="ma-page">

    <a href="{{ route('perfil.info') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Meu perfil
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Conta · Segurança</div>
            <h2>Alterar senha</h2>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="form-page">
        <div class="form-card">
            <form action="{{ route('perfil.senha.atualizar') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Senha atual</label>
                    <input type="password" name="current_password" placeholder="••••••••" required>
                    @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Nova senha</label>
                    <input type="password" name="password" placeholder="Mín. 8 caracteres" required>
                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Confirmar nova senha</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <div class="form-actions">
                    <a href="{{ route('perfil.info') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Atualizar senha</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
