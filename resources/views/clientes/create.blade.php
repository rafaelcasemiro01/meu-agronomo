{{--
    CLIENTES — ADICIONAR
    Rota: clientes.create (GET)  ·  Envia para: clientes.store (POST)
    Campos: nome, cpf, cultura, cidade, telefone, email, observacoes
--}}
@extends('dashboard')
@section('page-title', 'Adicionar cliente — Meu Agrônomo')
@section('topbar-title', 'Adicionar cliente')

@section('main-content')
<div class="ma-page">

    <a href="{{ route('clientes.index') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Clientes
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Gestão · Novo</div>
            <h2>Adicionar cliente</h2>
        </div>
    </div>

    <div class="form-page">
        <div class="form-card">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nome completo</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Ex.: João Bemvindo" required>
                    @error('nome')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>CPF / Documento</label>
                    <input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00">
                    @error('cpf')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Cultura principal</label>
                    <select name="cultura">
                        <option value="">Selecione…</option>
                        @foreach(['Soja','Milho','Café','Cana','Algodão','Hortaliças','Citros','Trigo','Feijão','Pastagem'] as $c)
                            <option value="{{ $c }}" {{ old('cultura') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Cidade / UF</label>
                    <input type="text" name="cidade" value="{{ old('cidade') }}" placeholder="Cidade/UF">
                </div>

                <div class="form-group">
                    <label>Telefone / WhatsApp</label>
                    <input type="text" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="cliente@email.com">
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Observações</label>
                    <textarea name="observacoes" placeholder="Notas internas sobre o cliente…">{{ old('observacoes') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('clientes.index') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Salvar cliente</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
