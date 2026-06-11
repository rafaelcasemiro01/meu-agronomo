@extends('dashboard')

@section('page-title', 'Início — Meu Agrônomo')
@section('topbar-title', 'Início')

@section('main-content')
<div class="ma-page">

    {{-- SAUDAÇÃO --}}
    <div class="ma-greet">
        <div>
            <div class="ma-greet__eyebrow">{{ $dataExtenso ?? '' }}</div>
            <h1>{{ $saudacao ?? 'Olá' }}, {{ $primeiroNome ?? '' }}.</h1>
            <p>{!! $aviso ?? 'Acompanhe seus clientes e visitas técnicas em um só lugar.' !!}</p>
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

        <a href="{{ route('relatorios.index') }}" class="card ma-stat" style="text-decoration:none; color:inherit;">
            <div class="ma-stat__top">
                <span class="t-eyebrow">Relatórios</span>
                <span class="ma-stat__ic">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3.5h8l4 4V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1Z"/><path d="M13.5 3.5V8h4"/><path d="M8.5 13h7M8.5 16.5h5"/></svg>
                </span>
            </div>
            <div class="ma-stat__val"><span class="ma-stat__num">{{ $totalRelatorios ?? 0 }}</span></div>
            <div class="ma-stat__sub">
                @if(($relatoriosRascunho ?? 0) > 0)
                    {{ $relatoriosRascunho }} em rascunho
                @else
                    todos finalizados
                @endif
            </div>
        </a>

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
                @php
                    $nomeCliente = optional($v->cliente)->nome ?? 'Cliente';
                    $sub = optional($v->cliente)->nome_propriedade ?: ($v->local_visita ?? 'Visita técnica');
                @endphp
                <a href="{{ route('visitas.minhas') }}" class="ma-visitrow">
                    <div class="ma-visitrow__date">
                        <span class="ma-visitrow__day">{{ optional($v->data_visita)->locale('pt_BR')->isoFormat('D MMM') ?? '—' }}</span>
                        <span class="ma-visitrow__time">{{ \Illuminate\Support\Str::substr($v->hora_visita, 0, 5) }}</span>
                    </div>
                    <div class="ma-visitrow__avatar">{{ strtoupper(\Illuminate\Support\Str::substr($nomeCliente, 0, 2)) }}</div>
                    <div class="ma-visitrow__main">
                        <div class="ma-visitrow__client">{{ $nomeCliente }}</div>
                        <div class="ma-visitrow__type">{{ $sub }}</div>
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

        {{-- Clientes recentes --}}
        <section class="card ma-block">
            <div class="ma-block__head">
                <h3>Clientes recentes</h3>
            </div>

            @forelse(($clientes ?? []) as $c)
                <a href="{{ route('clientes.show', $c) }}" class="ma-activity__row" style="text-decoration:none;color:inherit;">
                    <span class="ma-activity__ic">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 12 0v1"/></svg>
                    </span>
                    <div>
                        <div class="ma-activity__txt"><b>{{ $c->nome }}</b> · {{ $c->nome_propriedade }}</div>
                        <div class="ma-activity__when">{{ $c->cidade }}/{{ $c->estado }} · {{ optional($c->created_at)->locale('pt_BR')->diffForHumans() }}</div>
                    </div>
                </a>
            @empty
                <div class="empty-state" style="padding:32px 12px;">
                    Seus clientes aparecerão aqui conforme você cadastrar.
                </div>
            @endforelse

            <a href="{{ route('clientes.index') }}" class="btn btn-soft btn-block" style="margin-top:14px;">Ver todos os clientes</a>
        </section>

    </div>

</div>
@endsection
