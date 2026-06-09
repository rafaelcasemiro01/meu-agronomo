{{-- resources/views/home.blade.php --}}
@extends('dashboard')

@section('page-title', 'Meu Agrônomo — Início')

@section('main-content')
<div class="page-content">

    {{-- Métricas ──────────────────────────────── --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">Clientes cadastrados</div>
            <div class="metric-value">{{ $clientes->count() }}</div>
            <div class="metric-sub">no total</div>
            <div class="metric-accent"></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Clientes ativos</div>
            <div class="metric-value">{{ $clientes->where('status', 'ativo')->count() }}</div>
            <div class="metric-sub">ativos agora</div>
            <div class="metric-accent"></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Novos este mês</div>
            <div class="metric-value">—</div>
            <div class="metric-sub">em breve</div>
            <div class="metric-accent"></div>
        </div>
    </div>

    {{-- Atalhos ───────────────────────────────── --}}
    <section class="atalhos">
        <div class="section-title">Ações rápidas</div>
        <div class="quadro-atalhos">
            <a href="{{ route('clientes.create') }}" class="atalho">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Adicionar cliente
            </a>
            <a href="{{ route('visitas.agendar') }}" class="atalho">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Agendar visita
            </a>
            <a href="{{ route('clientes.index') }}" class="atalho">
                <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                Ver todos os clientes
            </a>
        </div>
    </section>

    {{-- Clientes recentes ─────────────────────── --}}
    <section class="card-section">
        <div class="card-section-header">
            <h3>Clientes recentes</h3>
            <a href="{{ route('clientes.index') }}" class="card-section-link">Ver todos →</a>
        </div>

        @forelse ($clientes->take(8) as $cliente)
            <div class="cliente-row">
                <div class="cliente-info">
                    <div class="cliente-avatar">
                        {{ strtoupper(substr($cliente->nome, 0, 2)) }}
                    </div>
                    <div>
                        <div class="cliente-nome">{{ $cliente->nome }}</div>
                        <div class="cliente-cpf">{{ $cliente->cpf }}</div>
                    </div>
                </div>
                <span class="cliente-badge">{{ $cliente->visitas ?? 0 }} visitas</span>
            </div>
        @empty
            <div class="empty-state">
                Nenhum cliente cadastrado ainda.
                <a href="{{ route('clientes.create') }}" style="color: var(--green-700); font-weight: 500;">Adicionar o primeiro →</a>
            </div>
        @endforelse
    </section>

</div>
@endsection
