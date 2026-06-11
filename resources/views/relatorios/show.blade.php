@extends('dashboard')
@section('page-title', $relatorio->titulo . ' — Meu Agrônomo')
@section('topbar-title', 'Relatório')

@push('styles')
<style>
    .rel-doc { max-width: 760px; }
    .rel-head { display: flex; align-items: flex-start; gap: 16px; flex-wrap: wrap; }
    .rel-head__ic { display: grid; place-items: center; width: 52px; height: 52px; border-radius: 13px; flex-shrink: 0; background: var(--accent-soft); color: var(--primary); }
    .rel-meta { display: flex; flex-wrap: wrap; gap: 8px 22px; margin-top: 14px; padding-top: 16px; border-top: 1px solid var(--border-soft); }
    .rel-meta div { font-size: 13.5px; }
    .rel-meta .k { color: var(--text-mute); display: block; font-size: 12px; margin-bottom: 2px; }
    .rel-meta .v { font-weight: 600; }
    .rel-sec { margin-top: 18px; }
    .rel-sec h3 { display:flex; align-items:center; gap:9px; font-size:13px; font-weight:700; margin:0 0 12px; color:var(--text); }
    .rel-sec h3 svg { width:16px; height:16px; stroke:var(--primary); fill:none; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
    .rel-sec p { font-size: 14.5px; line-height: 1.6; color: var(--text-dim); white-space: pre-line; margin: 0; }
    .rel-sec .vazio { color: var(--text-mute); font-style: italic; }
</style>
@endpush

@section('main-content')
<div class="ma-page">

    <a href="{{ route('relatorios.index') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Relatórios
    </a>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="rel-doc">
        {{-- Cabeçalho --}}
        <div class="card" style="padding:24px; margin-bottom:18px;">
            <div class="rel-head">
                <div class="rel-head__ic">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3.5h8l4 4V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1Z"/><path d="M13.5 3.5V8h4"/><path d="M8.5 13h7M8.5 16.5h5"/></svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:20px; font-weight:700; letter-spacing:-.02em;">{{ $relatorio->titulo }}</div>
                    <div class="t-mute" style="font-size:14px; margin-top:2px;">{{ $relatorio->tipo }}</div>
                </div>
                @if($relatorio->status === 'finalizado')
                    <span class="status-badge status-ativo">Finalizado</span>
                @else
                    <span class="status-badge status-pendente">Rascunho</span>
                @endif
            </div>

            <div class="rel-meta">
                <div>
                    <span class="k">Cliente</span>
                    <span class="v">{{ optional($relatorio->cliente)->nome ?? '—' }}</span>
                </div>
                <div>
                    <span class="k">Propriedade</span>
                    <span class="v">{{ optional($relatorio->cliente)->nome_propriedade ?? '—' }}</span>
                </div>
                <div>
                    <span class="k">Data</span>
                    <span class="v">{{ optional($relatorio->data_relatorio)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                </div>
                @if($relatorio->visitaTecnica)
                    <div>
                        <span class="k">Visita vinculada</span>
                        <span class="v">{{ optional($relatorio->visitaTecnica->data_visita)->format('d/m/Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Conteúdo --}}
        <div class="card" style="padding:24px; margin-bottom:18px;">
            <div class="rel-sec">
                <h3><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg> Diagnóstico</h3>
                @if($relatorio->diagnostico)
                    <p>{{ $relatorio->diagnostico }}</p>
                @else
                    <p class="vazio">Sem diagnóstico registrado.</p>
                @endif
            </div>

            <div class="rel-sec" style="margin-top:22px; padding-top:18px; border-top:1px solid var(--border-soft);">
                <h3><svg viewBox="0 0 24 24"><path d="M5 19c0-8 6-13 14-13 0 8-5 14-13 14-1 0-1 0-1-1Z"/><path d="M5 19c3-4 6-6 10-7.5"/></svg> Recomendações</h3>
                @if($relatorio->recomendacoes)
                    <p>{{ $relatorio->recomendacoes }}</p>
                @else
                    <p class="vazio">Sem recomendações registradas.</p>
                @endif
            </div>
        </div>

        {{-- Ações --}}
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('relatorios.edit', $relatorio) }}" class="btn btn-ghost">Editar</a>
            @if($relatorio->status !== 'finalizado')
                <form action="{{ route('relatorios.finalizar', $relatorio) }}" method="POST"
                      onsubmit="return confirm('Finalizar este relatório?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Finalizar relatório
                    </button>
                </form>
            @endif
            <button type="button" class="btn btn-soft" onclick="window.print()">Imprimir / PDF</button>
        </div>
    </div>

</div>
@endsection
