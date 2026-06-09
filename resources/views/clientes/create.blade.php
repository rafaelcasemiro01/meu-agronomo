@extends('dashboard') {{-- Estende o layout principal --}}

@section('page-title', 'Adicionar Cliente') {{-- Título da aba --}}

@section('main-content')
<main class="conteudo-principal">
    <header class="topo">
        <h2>Adicionar Cliente</h2>
    </header>

    <section class="form-cliente">
        {{-- Mensagens de sucesso ou erro --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <h3>Dados Pessoais</h3>
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14" required>
            </div>

            <div class="form-group">
                <label for="rg">RG (Opcional)</label>
                <input type="text" name="rg" id="rg" value="{{ old('rg') }}" maxlength="20">
            </div>

            <div class="form-group">
                <label for="contato">Contato Principal (Celular/WhatsApp)</label>
                <input type="text" name="contato" id="contato" value="{{ old('contato') }}" placeholder="(00) 00000-0000" maxlength="15" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone Fixo (Opcional)</label>
                <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" placeholder="(00) 0000-0000" maxlength="14">
            </div>

            <h3>Informações da Propriedade</h3>
            <div class="form-group">
                <label for="nome_propriedade">Nome da Propriedade Rural</label>
                <input type="text" name="nome_propriedade" id="nome_propriedade" value="{{ old('nome_propriedade') }}" required>
            </div>

            <div class="form-group">
                <label for="area_total_ha">Área Total (Hectares)</label>
                <input type="number" step="0.01" name="area_total_ha" id="area_total_ha" value="{{ old('area_total_ha') }}" required>
            </div>

            <div class="form-group">
                <label for="cultura_principal">Cultura Principal (Opcional)</label>
                <input type="text" name="cultura_principal" id="cultura_principal" value="{{ old('cultura_principal') }}">
            </div>

            <h3>Endereço da Propriedade</h3>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" value="{{ old('cep') }}" placeholder="00000-000" maxlength="9" required>
            </div>

            <div class="form-group">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" value="{{ old('endereco') }}" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" value="{{ old('cidade') }}" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado (UF)</label>
                <input type="text" name="estado" id="estado" value="{{ old('estado') }}" maxlength="50" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-salvar">Salvar Cliente</button>
                <a href="{{ route('clientes.index') }}" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </section>

    {{-- Script para máscaras --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mask = (input, func) => {
            if (!input) return;
            input.addEventListener('input', e => e.target.value = func(e.target.value));
        };

        const maskCPF = v => v.replace(/\D/g,'')
            .replace(/(\d{3})(\d)/,'$1.$2')
            .replace(/(\d{3})(\d)/,'$1.$2')
            .replace(/(\d{3})(\d{1,2})$/,'$1-$2');

        const maskCelular = v => v.replace(/\D/g,'')
            .replace(/(\d{2})(\d{5})(\d{0,4})/,'($1) $2-$3')
            .slice(0,15);

        const maskTelefone = v => v.replace(/\D/g,'')
            .replace(/(\d{2})(\d{4})(\d{0,4})/,'($1) $2-$3')
            .slice(0,14);

        const maskCEP = v => v.replace(/\D/g,'')
            .replace(/(\d{5})(\d)/,'$1-$2')
            .slice(0,9);

        mask(document.getElementById('cpf'), maskCPF);
        mask(document.getElementById('contato'), maskCelular);
        mask(document.getElementById('telefone'), maskTelefone);
        mask(document.getElementById('cep'), maskCEP);
    });
    </script>
</main>
@endsection
