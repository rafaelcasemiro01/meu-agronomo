@extends('dashboard')
@section('page-title', 'Novo relatório — Meu Agrônomo')
@section('topbar-title', 'Novo relatório')

@push('styles')
<style>
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0 18px; }
    @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
</style>
@endpush

@section('main-content')
<div class="ma-page">

    <a href="{{ route('relatorios.index') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Relatórios
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Visita técnica · Novo</div>
            <h2>Novo relatório</h2>
        </div>
    </div>

    @if($errors->any())<div class="alert alert-danger">Revise os campos destacados abaixo.</div>@endif

    @php $cidPre = old('cliente_id', optional(optional($visitaSelecionada)->cliente)->id); @endphp

    <div class="form-page" style="max-width:760px;">
        <div class="form-card">
            <form action="{{ route('relatorios.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>A partir de uma visita realizada (opcional)</label>
                    <select id="visita_tecnica_id" name="visita_tecnica_id">
                        <option value="">Nenhuma — relatório avulso</option>
                        @foreach($visitas as $v)
                            <option value="{{ $v->id }}"
                                    data-cliente="{{ $v->cliente_id }}"
                                    data-local="{{ $v->local_visita }}"
                                    {{ old('visita_tecnica_id', optional($visitaSelecionada)->id) == $v->id ? 'selected' : '' }}>
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
                                <option value="{{ $c->id }}" {{ $cidPre == $c->id ? 'selected' : '' }}>
                                    {{ $c->nome }}{{ $c->nome_propriedade ? ' — '.$c->nome_propriedade : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Tipo *</label>
                        <select name="tipo" required>
                            <option value="">Selecione…</option>
                            @foreach(\App\Models\Relatorio::TIPOS as $t)
                                <option value="{{ $t }}" {{ old('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('tipo')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Título *</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ex.: Análise de solo — talhão norte" required>
                        @error('titulo')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Data do relatório *</label>
                        <input type="date" name="data_relatorio" value="{{ old('data_relatorio', now()->format('Y-m-d')) }}" required>
                        @error('data_relatorio')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Diagnóstico</label>
                    <textarea name="diagnostico" rows="4" placeholder="O que foi observado em campo…">{{ old('diagnostico') }}</textarea>
                    @error('diagnostico')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Recomendações</label>
                    <textarea name="recomendacoes" rows="4" placeholder="Recomendações técnicas para o produtor…">{{ old('recomendacoes') }}</textarea>
                    @error('recomendacoes')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Situação</label>
                    <select name="status">
                        <option value="rascunho" {{ old('status') == 'rascunho' ? 'selected' : '' }}>Salvar como rascunho</option>
                        <option value="finalizado" {{ old('status') == 'finalizado' ? 'selected' : '' }}>Finalizar agora</option>
                    </select>
                </div>

                <div class="form-actions">
                    <a href="{{ route('relatorios.index') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Salvar relatório</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Ao escolher uma visita, pré-seleciona o cliente correspondente.
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
