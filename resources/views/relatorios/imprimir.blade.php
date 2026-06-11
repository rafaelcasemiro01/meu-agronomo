<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatório — {{ $relatorio->titulo }}</title>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root{
        --sage:#3f6553; --sage-700:#345145; --sage-50:#eef3ef; --sage-200:#b9d0c2;
        --ink:#16201b; --dim:#4d544f; --mute:#6c746f; --line:#e3e7e5; --good:#3f7d52; --warn:#b07c2e;
    }
    *{ box-sizing:border-box; margin:0; padding:0; }
    html,body{ background:#eceeec; }
    body{ font-family:"Hanken Grotesk",-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        color:var(--ink); letter-spacing:-.01em; -webkit-font-smoothing:antialiased; }

    /* Barra de ações (não imprime) */
    .toolbar{ position:sticky; top:0; z-index:10; display:flex; align-items:center; justify-content:space-between;
        gap:12px; padding:12px 18px; background:#fff; border-bottom:1px solid var(--line); }
    .toolbar .tb-info{ font-size:13px; color:var(--mute); }
    .toolbar .tb-actions{ display:flex; gap:8px; }
    .tb-btn{ font-family:inherit; font-size:13.5px; font-weight:600; cursor:pointer; text-decoration:none;
        border-radius:10px; padding:9px 16px; border:1px solid var(--line); background:#fff; color:var(--dim);
        display:inline-flex; align-items:center; gap:7px; transition:background .15s; }
    .tb-btn:hover{ background:var(--sage-50); }
    .tb-btn.primary{ background:var(--sage); border-color:var(--sage); color:#fff; }
    .tb-btn.primary:hover{ background:var(--sage-700); }
    .tb-btn svg{ width:16px; height:16px; stroke:currentColor; fill:none; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }

    /* Folha A4 */
    .sheet{ width:210mm; min-height:297mm; margin:24px auto; background:#fff; padding:22mm 20mm;
        box-shadow:0 10px 40px rgba(20,30,25,.14); position:relative; }

    /* Cabeçalho */
    .doc-head{ display:flex; align-items:flex-start; justify-content:space-between; gap:24px;
        padding-bottom:18px; border-bottom:2px solid var(--sage); }
    .brand{ display:flex; align-items:center; gap:12px; }
    .brand__icon{ width:42px; height:42px; border-radius:11px; background:var(--sage); display:grid; place-items:center; flex-shrink:0; }
    .brand__name{ font-size:17px; font-weight:700; letter-spacing:-.02em; line-height:1.15; white-space:nowrap; }
    .brand__sub{ font-size:11.5px; font-weight:500; color:var(--mute); margin-top:2px; line-height:1.2; white-space:nowrap; }
    .doc-head__right{ text-align:right; }
    .doc-kind{ font-size:11px; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--sage); }
    .doc-status{ display:inline-flex; align-items:center; gap:6px; margin-top:8px; font-size:11.5px; font-weight:700;
        padding:4px 11px; border-radius:999px; }
    .doc-status::before{ content:""; width:6px; height:6px; border-radius:50%; background:currentColor; }
    .st-final{ background:var(--sage-50); color:var(--good); }
    .st-rascunho{ background:#f6efe0; color:var(--warn); }

    /* Título */
    .doc-title{ margin-top:26px; }
    .doc-title h1{ font-size:27px; font-weight:700; letter-spacing:-.03em; line-height:1.1; }
    .doc-title .sub{ font-size:14px; color:var(--mute); margin-top:6px; }

    /* Meta (cliente / propriedade) */
    .meta{ display:grid; grid-template-columns:repeat(3,1fr); gap:18px 24px; margin-top:26px;
        padding:20px 22px; background:var(--sage-50); border-radius:14px; }
    .meta__item .k{ font-size:10.5px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--sage); }
    .meta__item .v{ font-size:14.5px; font-weight:600; margin-top:4px; }
    .meta__item .v.dim{ font-weight:500; color:var(--dim); }

    /* Seções */
    .section{ margin-top:30px; page-break-inside:avoid; }
    .section h2{ display:flex; align-items:center; gap:9px; font-size:13px; font-weight:700; letter-spacing:.02em;
        text-transform:uppercase; color:var(--sage); padding-bottom:10px; border-bottom:1px solid var(--line); }
    .section h2 svg{ width:17px; height:17px; stroke:currentColor; fill:none; stroke-width:1.9; stroke-linecap:round; stroke-linejoin:round; }
    .section .body{ font-size:14.5px; line-height:1.7; color:var(--ink); margin-top:14px; white-space:pre-line; }
    .section .body.vazio{ color:var(--mute); font-style:italic; }

    /* Assinatura */
    .sign{ margin-top:54px; display:flex; justify-content:space-between; align-items:flex-end; gap:40px; page-break-inside:avoid; }
    .sign__line{ flex:1; max-width:300px; text-align:center; }
    .sign__rule{ border-top:1px solid var(--ink); padding-top:8px; }
    .sign__name{ font-size:14px; font-weight:700; }
    .sign__role{ font-size:12px; color:var(--mute); margin-top:2px; }
    .sign__place{ font-size:12.5px; color:var(--dim); text-align:right; }

    /* Rodapé */
    .doc-foot{ margin-top:40px; padding-top:14px; border-top:1px solid var(--line);
        display:flex; justify-content:space-between; font-size:11px; color:var(--mute); }

    @media print{
        @page{ size:A4; margin:0; }
        html,body{ background:#fff; }
        .toolbar{ display:none; }
        .sheet{ width:auto; min-height:auto; margin:0; padding:18mm 16mm; box-shadow:none; }
    }
</style>
</head>
<body>

    <div class="toolbar">
        <span class="tb-info">Revise e use <b>Imprimir</b> para salvar como PDF (destino: “Salvar como PDF”).</span>
        <div class="tb-actions">
            <a href="{{ route('relatorios.show', $relatorio) }}" class="tb-btn">Voltar</a>
            <button type="button" class="tb-btn primary" onclick="window.print()">
                <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Imprimir / Salvar PDF
            </button>
        </div>
    </div>

    <div class="sheet">
        <div class="doc-head">
            <div class="brand">
                <div class="brand__icon">
                    <svg width="24" height="24" viewBox="0 0 64 64" fill="none">
                        <path d="M32 50V37" stroke="white" stroke-width="4.3" stroke-linecap="round"/>
                        <g transform="translate(32,38)">
                            <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                            <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                        </g>
                    </svg>
                </div>
                <div>
                    <div class="brand__name">Meu Agrônomo</div>
                    <div class="brand__sub">Gestão agrícola</div>
                </div>
            </div>
            <div class="doc-head__right">
                <div class="doc-kind">Relatório técnico</div>
                @if($relatorio->status === 'finalizado')
                    <span class="doc-status st-final">Finalizado</span>
                @else
                    <span class="doc-status st-rascunho">Rascunho</span>
                @endif
            </div>
        </div>

        <div class="doc-title">
            <h1>{{ $relatorio->titulo }}</h1>
            <div class="sub">{{ $relatorio->tipo }} · {{ optional($relatorio->data_relatorio)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
        </div>

        <div class="meta">
            <div class="meta__item">
                <div class="k">Cliente</div>
                <div class="v">{{ optional($relatorio->cliente)->nome ?? '—' }}</div>
            </div>
            <div class="meta__item">
                <div class="k">Propriedade</div>
                <div class="v">{{ optional($relatorio->cliente)->nome_propriedade ?? '—' }}</div>
            </div>
            <div class="meta__item">
                <div class="k">Localização</div>
                <div class="v dim">{{ optional($relatorio->cliente)->cidade }}{{ optional($relatorio->cliente)->estado ? '/'.$relatorio->cliente->estado : '' }}</div>
            </div>
            <div class="meta__item">
                <div class="k">Cultura</div>
                <div class="v dim">{{ optional($relatorio->cliente)->cultura_principal ?: '—' }}</div>
            </div>
            <div class="meta__item">
                <div class="k">Área total</div>
                <div class="v dim">{{ optional($relatorio->cliente)->area_total_ha ? rtrim(rtrim(number_format((float)$relatorio->cliente->area_total_ha, 2, ',', '.'), '0'), ',').' ha' : '—' }}</div>
            </div>
            @if($relatorio->visitaTecnica)
            <div class="meta__item">
                <div class="k">Visita vinculada</div>
                <div class="v dim">{{ optional($relatorio->visitaTecnica->data_visita)->format('d/m/Y') }}</div>
            </div>
            @endif
        </div>

        <div class="section">
            <h2><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg> Diagnóstico</h2>
            <div class="body {{ $relatorio->diagnostico ? '' : 'vazio' }}">{{ $relatorio->diagnostico ?: 'Sem diagnóstico registrado.' }}</div>
        </div>

        <div class="section">
            <h2><svg viewBox="0 0 24 24"><path d="M5 19c0-8 6-13 14-13 0 8-5 14-13 14-1 0-1 0-1-1Z"/><path d="M5 19c3-4 6-6 10-7.5"/></svg> Recomendações</h2>
            <div class="body {{ $relatorio->recomendacoes ? '' : 'vazio' }}">{{ $relatorio->recomendacoes ?: 'Sem recomendações registradas.' }}</div>
        </div>

        <div class="sign">
            <div class="sign__line">
                <div class="sign__rule">
                    <div class="sign__name">{{ $agronomo->name ?? 'Engenheiro Agrônomo' }}</div>
                    <div class="sign__role">Engenheiro Agrônomo{{ !empty($agronomo->crea) ? ' · CREA '.$agronomo->crea : '' }}</div>
                </div>
            </div>
            <div class="sign__place">
                {{ optional($relatorio->cliente)->cidade ?: '—' }}, {{ optional($relatorio->data_relatorio)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}
            </div>
        </div>

        <div class="doc-foot">
            <span>Meu Agrônomo · Relatório técnico</span>
            <span>Emitido em {{ now()->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</span>
        </div>
    </div>

</body>
</html>
