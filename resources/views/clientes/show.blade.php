@extends('dashboard')
@section('page-title', $cliente->nome . ' — Meu Agrônomo')
@section('topbar-title', 'Cliente')

@push('styles')
<style>
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    @media (max-width: 760px) { .detail-grid { grid-template-columns: 1fr; } }
    .detail-card { padding: 22px 24px; }
    .detail-card h3 { display: flex; align-items: center; gap: 9px; font-size: 13px; font-weight: 700; letter-spacing: .01em; margin: 0 0 16px; color: var(--text); }
    .detail-card h3 svg { width: 16px; height: 16px; stroke: var(--primary); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .detail-row { display: flex; justify-content: space-between; gap: 14px; padding: 9px 0; border-top: 1px solid var(--border-soft); font-size: 14px; }
    .detail-row:first-of-type { border-top: none; }
    .detail-row .k { color: var(--text-mute); }
    .detail-row .v { font-weight: 600; text-align: right; }
</style>
@endpush

@section('main-content')
<div class="ma-page">

    <a href="{{ route('clientes.index') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Clientes
    </a>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    {{-- Cabeçalho do cliente --}}
    <div class="card" style="padding:24px; display:flex; align-items:center; gap:16px; margin-bottom:18px; flex-wrap:wrap;">
        <div class="ma-sidebar__avatar" style="width:56px; height:56px; font-size:18px;">
            {{ strtoupper(\Illuminate\Support\Str::substr($cliente->nome, 0, 2)) }}
        </div>
        <div style="min-width:0;">
            <div style="font-size:20px; font-weight:700; letter-spacing:-.02em;">{{ $cliente->nome }}</div>
            <div class="t-mute" style="font-size:14px; margin-top:2px;">{{ $cliente->nome_propriedade }} · {{ $cliente->cidade }}/{{ $cliente->estado }}</div>
        </div>
        <div style="margin-left:auto; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            @if($cliente->status)
                <span class="status-badge status-ativo">Ativo</span>
            @else
                <span class="status-badge status-inativo">Inativo</span>
            @endif
            <a href="{{ route('visitas.agendar') }}" class="btn btn-ghost">Agendar visita</a>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>

    {{-- Dados --}}
    <div class="detail-grid" style="margin-bottom:18px;">
        <div class="card detail-card">
            <h3><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 12 0v1"/></svg> Dados pessoais</h3>
            <div class="detail-row"><span class="k">CPF</span><span class="v">{{ $cliente->cpf ?: '—' }}</span></div>
            <div class="detail-row"><span class="k">RG</span><span class="v">{{ $cliente->rg ?: '—' }}</span></div>
            <div class="detail-row"><span class="k">Contato</span><span class="v">{{ $cliente->contato ?: '—' }}</span></div>
            <div class="detail-row"><span class="k">Telefone</span><span class="v">{{ $cliente->telefone ?: '—' }}</span></div>
        </div>

        <div class="card detail-card">
            <h3><svg viewBox="0 0 24 24"><path d="M12 21s7-5.5 7-11a7 7 0 0 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/></svg> Endereço</h3>
            <div class="detail-row"><span class="k">Endereço</span><span class="v">{{ $cliente->endereco ?: '—' }}</span></div>
            <div class="detail-row"><span class="k">Cidade / UF</span><span class="v">{{ $cliente->cidade }}/{{ $cliente->estado }}</span></div>
            <div class="detail-row"><span class="k">CEP</span><span class="v">{{ $cliente->cep ?: '—' }}</span></div>
        </div>

        <div class="card detail-card">
            <h3><svg viewBox="0 0 24 24"><path d="M5 19c0-8 6-13 14-13 0 8-5 14-13 14-1 0-1 0-1-1Z"/><path d="M5 19c3-4 6-6 10-7.5"/></svg> Propriedade</h3>
            <div class="detail-row"><span class="k">Nome</span><span class="v">{{ $cliente->nome_propriedade ?: '—' }}</span></div>
            <div class="detail-row"><span class="k">Área total</span><span class="v">{{ rtrim(rtrim(number_format((float)$cliente->area_total_ha, 2, ',', '.'), '0'), ',') }} ha</span></div>
            <div class="detail-row"><span class="k">Cultura</span><span class="v">{{ $cliente->cultura_principal ?: '—' }}</span></div>
        </div>

        <div class="card detail-card">
            <h3><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg> Resumo</h3>
            @php $visitasCliente = $cliente->visitasTecnicas()->latest('data_visita')->get(); @endphp
            <div class="detail-row"><span class="k">Total de visitas</span><span class="v">{{ $visitasCliente->count() }}</span></div>
            <div class="detail-row"><span class="k">Agendadas</span><span class="v">{{ $visitasCliente->where('status', 'agendada')->count() }}</span></div>
            <div class="detail-row"><span class="k">Realizadas</span><span class="v">{{ $visitasCliente->where('status', 'realizada')->count() }}</span></div>
            <div class="detail-row"><span class="k">Cliente desde</span><span class="v">{{ optional($cliente->created_at)->format('d/m/Y') }}</span></div>
        </div>
    </div>

    {{-- Histórico de visitas --}}
    <section class="card ma-block">
        <div class="ma-block__head">
            <h3>Histórico de visitas</h3>
            <a href="{{ route('visitas.agendar') }}" class="ma-block__link">Agendar <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
        </div>
        @forelse($visitasCliente as $visita)
            @php $badge = $visita->status === 'realizada' ? 'ativo' : ($visita->status === 'cancelada' ? 'inativo' : 'pendente'); @endphp
            <div class="ma-visitrow" style="cursor:default;">
                <div class="ma-visitrow__date">
                    <span class="ma-visitrow__day">{{ optional($visita->data_visita)->translatedFormat('d M') }}</span>
                    <span class="ma-visitrow__time">{{ \Illuminate\Support\Str::substr($visita->hora_visita, 0, 5) }}</span>
                </div>
                <div class="ma-visitrow__main" style="flex:1;">
                    <div class="ma-visitrow__client">{{ $visita->local_visita ?: 'Visita técnica' }}</div>
                    <div class="ma-visitrow__type">{{ \Illuminate\Support\Str::limit($visita->observacoes, 60) ?: 'Sem observações' }}</div>
                </div>
                <span class="status-badge status-{{ $badge }}">{{ ucfirst($visita->status) }}</span>
            </div>
        @empty
            <div class="empty-state" style="padding:32px 12px;">
                Nenhuma visita registrada para este cliente.<br>
                <a href="{{ route('visitas.agendar') }}" style="color:var(--primary);font-weight:600;">Agendar a primeira →</a>
            </div>
        @endforelse
    </section>

</div>
@endsection
