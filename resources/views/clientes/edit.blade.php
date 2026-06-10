{{--
    CLIENTES — EDITAR
    Rota: clientes.edit (GET, {cliente})  ·  Envia para: clientes.update (PUT, {cliente})
    Variável esperada: $cliente
--}}
@extends('dashboard')
@section('page-title', 'Editar cliente — Meu Agrônomo')
@section('topbar-title', 'Editar cliente')

@section('main-content')
<div class="ma-page">

    <a href="{{ route('clientes.index') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Clientes
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Gestão · Editar</div>
            <h2>{{ $cliente->nome ?? 'Editar cliente' }}</h2>
        </div>
    </div>

    <div class="form-page">
        <div class="form-card">
            <form action="{{ route('clientes.update', $cliente->id ?? 0) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nome completo</label>
                    <input type="text" name="nome" value="{{ old('nome', $cliente->nome ?? '') }}" required>
                    @error('nome')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>CPF / Documento</label>
                    <input type="text" name="cpf" value="{{ old('cpf', $cliente->cpf ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Cultura principal</label>
                    <select name="cultura">
                        <option value="">Selecione…</option>
                        @foreach(['Soja','Milho','Café','Cana','Algodão','Hortaliças','Citros','Trigo','Feijão','Pastagem'] as $c)
                            <option value="{{ $c }}" {{ old('cultura', $cliente->cultura ?? '') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Cidade / UF</label>
                    <input type="text" name="cidade" value="{{ old('cidade', $cliente->cidade ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Telefone / WhatsApp</label>
                    <input type="text" name="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}">
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $cliente->email ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        @foreach(['ativo' => 'Ativo', 'inativo' => 'Inativo', 'pendente' => 'Pendente'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('status', $cliente->status ?? 'ativo') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Observações</label>
                    <textarea name="observacoes">{{ old('observacoes', $cliente->observacoes ?? '') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('clientes.index') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
