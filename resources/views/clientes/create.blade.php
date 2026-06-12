@extends('dashboard')
@section('page-title', 'Adicionar cliente — Meu Agrônomo')
@section('topbar-title', 'Adicionar cliente')

@push('styles')
<style>
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0 18px; }
    @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
    .form-sec-title { font-size: 13px; font-weight: 700; letter-spacing: .01em; color: var(--text); margin: 26px 0 16px; padding-top: 22px; border-top: 1px solid var(--border-soft); }
    .form-sec-title:first-child { margin-top: 0; padding-top: 0; border-top: none; }
</style>
@endpush

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

    @if($errors->any())
        <div class="alert alert-danger">Revise os campos destacados abaixo.</div>
    @endif

    <div class="form-page" style="max-width:760px;">
        <div class="form-card">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="form-sec-title">Dados do cliente</div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Nome completo *</label>
                        <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Ex.: João Bemvindo" required>
                        @error('nome')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>CPF *</label>
                        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" required>
                        @error('cpf')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>RG</label>
                        <input type="text" name="rg" value="{{ old('rg') }}" placeholder="Opcional">
                        @error('rg')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Contato (WhatsApp) *</label>
                        <input type="text" id="contato" name="contato" value="{{ old('contato') }}" placeholder="(00) 00000-0000" required>
                        @error('contato')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Telefone fixo</label>
                        <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 0000-0000">
                        @error('telefone')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-sec-title">Endereço</div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>CEP *</label>
                        <input type="text" id="cep" name="cep" value="{{ old('cep') }}" placeholder="00000-000" required>
                        <div class="cep-hint">Digite o CEP para preencher o endereço automaticamente.</div>
                        @error('cep')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" id="numero" name="numero" value="{{ old('numero') }}" placeholder="Ex.: 123" inputmode="numeric">
                    </div>
                    <div class="form-group" style="grid-column:1 / -1;">
                        <label>Endereço *</label>
                        <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" placeholder="Rua e bairro (preenchido pelo CEP)" required>
                        @error('endereco')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Cidade *</label>
                        <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}" placeholder="Cidade" required>
                        @error('cidade')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Estado (UF) *</label>
                        <select id="estado" name="estado" required>
                            <option value="">Selecione…</option>
                            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                                <option value="{{ $uf }}" {{ old('estado') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                            @endforeach
                        </select>
                        @error('estado')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-sec-title">Propriedade</div>
                <div class="form-grid-2">
                    <div class="form-group" style="grid-column:1 / -1;">
                        <label>Nome da propriedade *</label>
                        <input type="text" name="nome_propriedade" value="{{ old('nome_propriedade') }}" placeholder="Ex.: Fazenda Santa Helena" required>
                        @error('nome_propriedade')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Área total (ha) *</label>
                        <input type="number" step="0.01" min="0.01" name="area_total_ha" value="{{ old('area_total_ha') }}" placeholder="0,00" required>
                        @error('area_total_ha')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Cultura principal</label>
                        <select name="cultura_principal">
                            <option value="">Selecione…</option>
                            @foreach(['Soja','Milho','Café','Cana','Algodão','Hortaliças','Citros','Trigo','Feijão','Pastagem'] as $c)
                                <option value="{{ $c }}" {{ old('cultura_principal') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        @error('cultura_principal')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
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
