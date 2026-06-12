@extends('dashboard')
@section('page-title', 'Minhas visitas — Meu Agrônomo')
@section('topbar-title', 'Minhas visitas')

@push('styles')
<style>
    .visita-item { display: flex; align-items: center; gap: 15px; border-top: 1px solid var(--border-soft); padding: 15px 4px; }
    .visita-item:first-child { border-top: none; }
    .visita-actions { display: flex; gap: 6px; flex-shrink: 0; }
    @media (max-width: 620px) {
        .visita-item { flex-wrap: wrap; }
        .visita-actions { width: 100%; justify-content: flex-end; }
    }
</style>
@endpush

@section('main-content')
<div class="ma-page">

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Visita técnica</div>
            <h2>Minhas visitas</h2>
        </div>
        <a href="{{ route('visitas.agendar') }}" class="btn-add">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Agendar visita
        </a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    @php $statusAtual = request('status', 'agendada'); @endphp
    <div class="filter-bar">
        <a href="{{ route('visitas.minhas', ['status' => 'agendada']) }}" class="filter-btn {{ $statusAtual == 'agendada' ? 'active-filtro' : '' }}">Agendadas</a>
        <a href="{{ route('visitas.minhas', ['status' => 'realizada']) }}" class="filter-btn {{ $statusAtual == 'realizada' ? 'active-filtro' : '' }}">Realizadas</a>
        <a href="{{ route('visitas.minhas', ['status' => 'cancelada']) }}" class="filter-btn {{ $statusAtual == 'cancelada' ? 'active-filtro' : '' }}">Canceladas</a>
        <a href="{{ route('visitas.minhas', ['status' => 'todas']) }}" class="filter-btn {{ $statusAtual == 'todas' ? 'active-filtro' : '' }}">Todas</a>
    </div>

    <div class="card ma-block">
        @forelse($visitas as $visita)
            @php
                $nomeCliente = optional($visita->cliente)->nome ?? 'Cliente';
                $sub = $visita->local_visita ?: (optional($visita->cliente)->nome_propriedade ?? 'Visita técnica');
                $badge = $visita->status === 'realizada' ? 'ativo' : ($visita->status === 'cancelada' ? 'inativo' : 'pendente');
            @endphp
            <div class="visita-item">
                <div class="ma-visitrow__date">
                    <span class="ma-visitrow__day">{{ optional($visita->data_visita)->translatedFormat('d M') }}</span>
                    <span class="ma-visitrow__time">{{ \Illuminate\Support\Str::substr($visita->hora_visita, 0, 5) }}</span>
                </div>
                <div class="ma-visitrow__avatar">{{ strtoupper(\Illuminate\Support\Str::substr($nomeCliente, 0, 2)) }}</div>
                <div class="ma-visitrow__main" style="flex:1;min-width:0;">
                    <div class="ma-visitrow__client">{{ $nomeCliente }}</div>
                    <div class="ma-visitrow__type">{{ $sub }}</div>
                </div>
                <span class="status-badge status-{{ $badge }}">{{ ucfirst($visita->status) }}</span>

                @if($visita->status === 'agendada')
                    <div class="visita-actions">
                        <form action="{{ route('visitas.realizar', $visita) }}" method="POST"
                              onsubmit="return confirm('Confirmar que esta visita foi realizada?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn edit">Realizar</button>
                        </form>
                        <form action="{{ route('visitas.cancelar', $visita) }}" method="POST"
                              onsubmit="return confirm('Cancelar esta visita?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn danger">Cancelar</button>
                        </form>
                    </div>
                @else
                    <div class="visita-actions">
                        <form action="{{ route('visitas.reabrir', $visita) }}" method="POST"
                              onsubmit="return confirm('Reabrir esta visita? Ela volta para “agendada”.');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn edit">Reabrir</button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state" style="padding:40px 16px;">
                Nenhuma visita {{ $statusAtual != 'todas' ? $statusAtual : '' }} por aqui.<br>
                <a href="{{ route('visitas.agendar') }}" style="color:var(--primary);font-weight:600;">Agendar uma visita →</a>
            </div>
        @endforelse
    </div>

    @if(method_exists($visitas, 'links'))
        <div style="margin-top:18px;">{{ $visitas->appends(request()->query())->links() }}</div>
    @endif

</div>
@endsection
