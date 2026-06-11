@extends('dashboard')
@section('page-title', 'Meu perfil — Meu Agrônomo')
@section('topbar-title', 'Meu perfil')

@push('styles')
<style>
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0 18px; }
    @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
</style>
@endpush

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
            {{ strtoupper(\Illuminate\Support\Str::substr($user->name, 0, 2)) }}
        </div>
        <div>
            <div style="font-size:18px; font-weight:700; letter-spacing:-.02em;">{{ $user->name }}</div>
            <div class="t-mute" style="font-size:14px; margin-top:2px;">{{ $user->email }}</div>
        </div>
        <span class="badge" style="margin-left:auto;">Engenheiro Agrônomo</span>
    </div>

    <div class="form-page" style="max-width:680px;">
        {{-- Dados pessoais --}}
        <div class="form-card" style="margin-bottom:18px;">
            <h3 style="font-size:15px; font-weight:700; letter-spacing:-.02em; margin:0 0 18px;">Dados pessoais</h3>
            <form action="{{ route('perfil.update.info') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Nome completo *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>E-mail *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Celular</label>
                        <input type="text" id="contato" name="celular" value="{{ old('celular', $user->celular) }}" placeholder="(00) 00000-0000">
                        @error('celular')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Data de nascimento</label>
                        <input type="date" name="data_nascimento" value="{{ old('data_nascimento', optional($user->data_nascimento)->format('Y-m-d')) }}">
                        @error('data_nascimento')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Registro profissional (CREA)</label>
                    <input type="text" name="crea" value="{{ old('crea', $user->crea) }}" placeholder="Ex.: 123456-D/GO">
                    <div class="t-mute" style="font-size:12px; margin-top:6px;">Aparece automaticamente na assinatura dos relatórios em PDF.</div>
                    @error('crea')<span class="text-danger">{{ $message }}</span>@enderror
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
