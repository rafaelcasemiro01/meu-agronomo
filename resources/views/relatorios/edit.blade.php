@extends('dashboard')
@section('page-title', 'Editar relatório — Meu Agrônomo')
@section('topbar-title', 'Editar relatório')

@push('styles')
<style>
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0 18px; }
    @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
</style>
@endpush

@section('main-content')
<div class="ma-page">

    <a href="{{ route('relatorios.show', $relatorio) }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Voltar ao relatório
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Visita técnica · Editar</div>
            <h2>{{ $relatorio->titulo }}</h2>
        </div>
    </div>

    @if($errors->any())<div class="alert alert-danger">Revise os campos destacados abaixo.</div>@endif

    <div class="form-page" style="max-width:760px;">
        <div class="form-card">
            <form action="{{ route('relatorios.update', $relatorio) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Visita técnica vinculada (opcional)</label>
                    <select id="visita_tecnica_id" name="visita_tecnica_id">
                        <option value="">Nenhuma — relatório avulso</option>
                        @foreach($visitas as $v)
                            <option value="{{ $v->id }}" data-cliente="{{ $v->cliente_id }}"
                                    {{ old('visita_tecnica_id', $relatorio->visita_tecnica_id) == $v->id ? 'selected' : '' }}>
                                {{ optional($v->data_visita)->format('d/m/Y') }} — {{ optional($v->cliente)->nome }} ({{ $v->local_visita ?: 'sem local' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Cliente *</label>
                        <select id="cliente_id" name="cliente_id" required>
                            <option value="">Selecione…</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" {{ old('cliente_id', $relatorio->cliente_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->nome }}{{ $c->nome_propriedade ? ' — '.$c->nome_propriedade : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Tipo *</label>
                        <select name="tipo" required>
                            @foreach(\App\Models\Relatorio::TIPOS as $t)
                                <option value="{{ $t }}" {{ old('tipo', $relatorio->tipo) == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('tipo')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Título *</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $relatorio->titulo) }}" required>
                        @error('titulo')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Data do relatório *</label>
                        <input type="date" name="data_relatorio" value="{{ old('data_relatorio', optional($relatorio->data_relatorio)->format('Y-m-d')) }}" required>
                        @error('data_relatorio')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Diagnóstico</label>
                    <textarea name="diagnostico" rows="4">{{ old('diagnostico', $relatorio->diagnostico) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Recomendações</label>
                    <textarea name="recomendacoes" rows="4">{{ old('recomendacoes', $relatorio->recomendacoes) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Situação</label>
                    <select name="status">
                        <option value="rascunho" {{ old('status', $relatorio->status) == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                        <option value="finalizado" {{ old('status', $relatorio->status) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                <div class="form-actions">
                    <a href="{{ route('relatorios.show', $relatorio) }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    (function () {
        const selV = document.getElementById('visita_tecnica_id');
        const selC = document.getElementById('cliente_id');
        if (selV && selC) {
            selV.addEventListener('change', function () {
                const opt = this.options[this.selectedIndex];
                const cid = opt ? opt.getAttribute('data-cliente') : '';
                if (cid) selC.value = cid;
            });
        }
    })();
</script>
@endpush
