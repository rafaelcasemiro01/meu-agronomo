@extends('dashboard')
@section('page-title', 'Agendar visita — Meu Agrônomo')
@section('topbar-title', 'Agendar visita')

@push('styles')
<style>
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0 18px; }
    @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
</style>
@endpush

@section('main-content')
<div class="ma-page">

    <a href="{{ route('visitas.minhas') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Minhas visitas
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Visita técnica</div>
            <h2>Agendar visita</h2>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">Revise os campos destacados abaixo.</div>@endif

    <div class="form-page" style="max-width:680px;">
        <div class="form-card">
            <form action="{{ route('visitas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Cliente *</label>
                    <select id="cliente_id" name="cliente_id" required>
                        <option value="">Selecione o cliente…</option>
                        @forelse($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                    data-endereco="{{ trim(($cliente->endereco ? $cliente->endereco.', ' : '').$cliente->cidade.'/'.$cliente->estado, ', ') }}"
                                    {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }}{{ $cliente->nome_propriedade ? ' — '.$cliente->nome_propriedade : '' }}
                            </option>
                        @empty
                            <option value="" disabled>Nenhum cliente cadastrado</option>
                        @endforelse
                    </select>
                    @error('cliente_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Data da visita *</label>
                        <input type="date" name="data_visita" value="{{ old('data_visita') }}" min="{{ now()->toDateString() }}" required>
                        @error('data_visita')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Horário *</label>
                        <input type="time" name="hora_visita" value="{{ old('hora_visita') }}" required>
                        @error('hora_visita')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Local da visita</label>
                    <input type="text" id="local_visita" name="local_visita" value="{{ old('local_visita') }}" placeholder="Preenchido automaticamente pelo cliente — ou edite">
                    @error('local_visita')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Observações</label>
                    <textarea name="observacoes" placeholder="Pontos a verificar, materiais a levar…">{{ old('observacoes') }}</textarea>
                    @error('observacoes')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('visitas.minhas') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Confirmar agendamento</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Auto-preenche o "Local da visita" com o endereço do cliente selecionado
    (function () {
        const sel = document.getElementById('cliente_id');
        const local = document.getElementById('local_visita');
        if (sel && local) {
            sel.addEventListener('change', function () {
                const opt = this.options[this.selectedIndex];
                const end = opt ? opt.getAttribute('data-endereco') : '';
                if (end && !local.value) local.value = end;
            });
        }
    })();
</script>
@endpush
