{{--
    VISITAS — MINHAS VISITAS
    Rota: visitas.minhas (GET)  ·  Variável esperada: $visitas (coleção)
    Campos lidos: ->id, ->cliente (nome ou relação), ->tipo, ->data (Carbon), ->hora, ->status
--}}
@extends('dashboard')
@section('page-title', 'Minhas visitas — Meu Agrônomo')
@section('topbar-title', 'Minhas visitas')

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

    <div class="filter-bar">
        <a href="{{ route('visitas.minhas') }}" class="filter-btn {{ !request('status') ? 'active-filtro' : '' }}">Todas</a>
        <a href="{{ route('visitas.minhas', ['status' => 'agendada']) }}" class="filter-btn {{ request('status') == 'agendada' ? 'active-filtro' : '' }}">Agendadas</a>
        <a href="{{ route('visitas.minhas', ['status' => 'concluida']) }}" class="filter-btn {{ request('status') == 'concluida' ? 'active-filtro' : '' }}">Concluídas</a>
    </div>

    <div class="card ma-block">
        @forelse(($visitas ?? []) as $visita)
            @php
                $nomeCliente = is_object($visita->cliente ?? null) ? ($visita->cliente->nome ?? 'Cliente') : ($visita->cliente ?? 'Cliente');
                $st = strtolower($visita->status ?? 'agendada');
            @endphp
            <a href="{{ route('visitas.minhas') }}" class="ma-visitrow">
                <div class="ma-visitrow__date">
                    <span class="ma-visitrow__day">{{ optional($visita->data ?? null)->translatedFormat('d M') ?? '—' }}</span>
                    <span class="ma-visitrow__time">{{ $visita->hora ?? '' }}</span>
                </div>
                <div class="ma-visitrow__avatar">{{ strtoupper(substr($nomeCliente, 0, 2)) }}</div>
                <div class="ma-visitrow__main">
                    <div class="ma-visitrow__client">{{ $nomeCliente }}</div>
                    <div class="ma-visitrow__type">{{ $visita->tipo ?? 'Visita técnica' }}</div>
                </div>
                <span class="status-badge status-{{ $st == 'concluida' ? 'ativo' : 'pendente' }}" style="margin-right:6px;">{{ ucfirst($st) }}</span>
                <span class="ma-visitrow__chev"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            </a>
        @empty
            <div class="empty-state" style="padding:40px 16px;">
                Nenhuma visita por aqui ainda.<br>
                <a href="{{ route('visitas.agendar') }}" style="color:var(--primary);font-weight:600;">Agendar a primeira →</a>
            </div>
        @endforelse
    </div>

</div>
@endsection
