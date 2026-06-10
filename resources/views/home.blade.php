{{--
    ============================================================
    DASHBOARD — CONTEÚDO (Início)
    Estende o layout em resources/views/dashboard.blade.php
    Aponte sua rota /dashboard para esta view, OU cole o
    @section('main-content') dentro da sua view de conteúdo atual.

    Variáveis esperadas do controller (todas com fallback seguro):
      $totalClientes, $clientesAtivos, $visitasAgendadas, $novosMes
      $proximasVisitas  (coleção; cada item: ->cliente, ->tipo, ->data, ->hora)
      $atividades       (coleção; cada item: ->titulo, ->descricao, ->quando)
    ============================================================
--}}
@extends('dashboard')

@section('page-title', 'Início — Meu Agrônomo')
@section('topbar-title', 'Início')

@section('main-content')
<div class="ma-page">

    @php
        $hora = now()->hour;
        $saudacao = $hora < 12 ? 'Bom dia' : ($hora < 18 ? 'Boa tarde' : 'Boa noite');
        $primeiroNome = explode(' ', trim(Auth::user()->name))[0];
    @endphp

    {{-- SAUDAÇÃO --}}
    <div class="ma-greet">
        <div>
            <div class="ma-greet__eyebrow">{{ ucfirst(now()->translatedFormat('l · d M Y')) }}</div>
            <h1>{{ $saudacao }}, {{ $primeiroNome }}.</h1>
            <p>Acompanhe seus clientes e visitas técnicas em um só lugar.</p>
        </div>
        <div class="ma-greet__actions">
            <a href="{{ route('clientes.create') }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                Novo cliente
            </a>
            <a href="{{ route('visitas.agendar') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/></svg>
                Agendar visita
            </a>
        </div>
    </div>

    {{-- CARDS DE MÉTRICAS --}}
    <div class="ma-stats">
        <div class="card ma-stat">
            <div class="ma-stat__top">
                <span class="t-eyebrow">Clientes ativos</span>
                <span class="ma-stat__ic">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="9" cy="7" r="4"/><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </span>
            </div>
            <div class="ma-stat__val"><span class="ma-stat__num">{{ $clientesAtivos ?? 0 }}</span></div>
            <div class="ma-stat__sub">de {{ $totalClientes ?? 0 }} cadastrados</div>
        </div>

        <div class="card ma-stat">
            <div class="ma-stat__top">
                <span class="t-eyebrow">Visitas agendadas</span>
                <span class="ma-stat__ic">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                </span>
            </div>
            <div class="ma-stat__val"><span class="ma-stat__num">{{ $visitasAgendadas ?? 0 }}</span></div>
            <div class="ma-stat__sub">nos próximos 7 dias</div>
        </div>

        <div class="card ma-stat">
            <div class="ma-stat__top">
                <span class="t-eyebrow">Clientes cadastrados</span>
                <span class="ma-stat__ic">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </span>
            </div>
            <div class="ma-stat__val"><span class="ma-stat__num">{{ $totalClientes ?? 0 }}</span></div>
            <div class="ma-stat__sub">no total</div>
        </div>

        <div class="card ma-stat">
            <div class="ma-stat__top">
                <span class="t-eyebrow">Novos este mês</span>
                <span class="ma-stat__ic">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 15l5-5 3.5 3.5L20 6"/><polyline points="15 6 20 6 20 11"/></svg>
                </span>
            </div>
            <div class="ma-stat__val"><span class="ma-stat__num">{{ $novosMes ?? 0 }}</span></div>
            <div class="ma-stat__sub">últimos 30 dias</div>
        </div>
    </div>

    {{-- DUAS COLUNAS --}}
    <div class="ma-cols">

        {{-- Próximas visitas --}}
        <section class="card ma-block">
            <div class="ma-block__head">
                <h3>Próximas visitas</h3>
                <a href="{{ route('visitas.minhas') }}" class="ma-block__link">
                    Ver todas
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            @forelse(($proximasVisitas ?? []) as $v)
                <a href="{{ route('visitas.minhas') }}" class="ma-visitrow">
                    <div class="ma-visitrow__date">
                        <span class="ma-visitrow__day">{{ optional($v->data ?? null)->translatedFormat('D') ?? '—' }}</span>
                        <span class="ma-visitrow__time">{{ $v->hora ?? '' }}</span>
                    </div>
                    <div class="ma-visitrow__avatar">{{ strtoupper(substr($v->cliente ?? 'CL', 0, 2)) }}</div>
                    <div class="ma-visitrow__main">
                        <div class="ma-visitrow__client">{{ $v->cliente ?? 'Cliente' }}</div>
                        <div class="ma-visitrow__type">{{ $v->tipo ?? 'Visita técnica' }}</div>
                    </div>
                    <span class="ma-visitrow__chev"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
            @empty
                <div class="empty-state" style="padding:32px 12px;">
                    Nenhuma visita agendada ainda.<br>
                    <a href="{{ route('visitas.agendar') }}" style="color:var(--primary);font-weight:600;">Agendar a primeira →</a>
                </div>
            @endforelse
        </section>

        {{-- Atividade recente --}}
        <section class="card ma-block">
            <div class="ma-block__head">
                <h3>Atividade recente</h3>
            </div>

            @forelse(($atividades ?? []) as $a)
                <div class="ma-activity__row">
                    <span class="ma-activity__ic">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </span>
                    <div>
                        <div class="ma-activity__txt"><b>{{ $a->titulo ?? '' }}</b> {{ $a->descricao ?? '' }}</div>
                        <div class="ma-activity__when">{{ $a->quando ?? '' }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="padding:32px 12px;">
                    Suas ações aparecerão aqui conforme você usar o sistema.
                </div>
            @endforelse

            <a href="{{ route('clientes.index') }}" class="btn btn-soft btn-block" style="margin-top:14px;">Ver todos os clientes</a>
        </section>

    </div>

</div>
@endsection
