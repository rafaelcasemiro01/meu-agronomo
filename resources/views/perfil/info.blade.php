{{--
    PERFIL — INFORMAÇÕES
    Rota: perfil.info (GET)  ·  Envia para: perfil.atualizar (PUT)  [ajuste o nome se diferente]
    Usa Auth::user()
--}}
@extends('dashboard')
@section('page-title', 'Meu perfil — Meu Agrônomo')
@section('topbar-title', 'Meu perfil')

@section('main-content')
<div class="ma-page">

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Conta</div>
            <h2>Meu perfil</h2>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    {{-- Cartão de identidade --}}
    <div class="card" style="padding:24px; display:flex; align-items:center; gap:16px; margin-bottom:18px;">
        <div class="ma-sidebar__avatar" style="width:56px; height:56px; font-size:18px;">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div>
            <div style="font-size:18px; font-weight:700; letter-spacing:-.02em;">{{ Auth::user()->name }}</div>
            <div class="t-mute" style="font-size:14px; margin-top:2px;">{{ Auth::user()->email }}</div>
        </div>
        <span class="badge" style="margin-left:auto;">Engenheiro Agrônomo</span>
    </div>

    <div class="form-page">
        {{-- Dados pessoais --}}
        <div class="form-card" style="margin-bottom:18px;">
            <h3 style="font-size:15px; font-weight:700; letter-spacing:-.02em; margin:0 0 18px;">Dados pessoais</h3>
            <form action="{{ route('perfil.atualizar') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nome completo</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-salvar">Salvar dados</button>
                </div>
            </form>
        </div>

        {{-- Atalho para senha --}}
        <div class="form-card">
            <h3 style="font-size:15px; font-weight:700; letter-spacing:-.02em; margin:0 0 8px;">Segurança</h3>
            <p class="t-mute" style="font-size:14px; margin:0 0 18px;">Mantenha sua conta protegida com uma senha forte.</p>
            <a href="{{ route('perfil.senha') }}" class="btn-cancelar">Alterar senha</a>
        </div>
    </div>

</div>
@endsection
