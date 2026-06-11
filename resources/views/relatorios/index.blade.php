@extends('dashboard')
@section('page-title', 'Relatórios — Meu Agrônomo')
@section('topbar-title', 'Relatórios')

@section('main-content')
<div class="ma-page">

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Visita técnica</div>
            <h2>Relatórios</h2>
        </div>
        <a href="{{ route('relatorios.create') }}" class="btn-add">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Novo relatório
        </a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    @php $statusAtual = $status ?? 'todos'; @endphp
    <div class="filter-bar">
        <a href="{{ route('relatorios.index', array_filter(['status' => 'todos', 'search' => request('search')])) }}"
           class="filter-btn {{ $statusAtual == 'todos' ? 'active-filtro' : '' }}">Todos</a>
        <a href="{{ route('relatorios.index', array_filter(['status' => 'rascunho', 'search' => request('search')])) }}"
           class="filter-btn {{ $statusAtual == 'rascunho' ? 'active-filtro' : '' }}">Rascunhos</a>
        <a href="{{ route('relatorios.index', array_filter(['status' => 'finalizado', 'search' => request('search')])) }}"
           class="filter-btn {{ $statusAtual == 'finalizado' ? 'active-filtro' : '' }}">Finalizados</a>
    </div>

    <div class="tabela-wrapper">
        <table class="tabela-clientes">
            <thead>
                <tr>
                    <th>Relatório</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Situação</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($relatorios as $relatorio)
                <tr>
                    <td>
                        <div class="cliente-info">
                            <div class="cliente-avatar" style="border-radius:11px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3.5h8l4 4V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1Z"/><path d="M13.5 3.5V8h4"/><path d="M8.5 13h7M8.5 16.5h5"/></svg>
                            </div>
                            <div style="min-width:0;">
                                <div class="cliente-nome">{{ $relatorio->titulo }}</div>
                                <div class="cliente-cpf">{{ $relatorio->tipo }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:13.5px;">{{ optional($relatorio->cliente)->nome ?? '—' }}</div>
                        <div class="cliente-cpf">{{ optional($relatorio->cliente)->nome_propriedade }}</div>
                    </td>
                    <td>{{ optional($relatorio->data_relatorio)->locale('pt_BR')->isoFormat('D MMM YYYY') }}</td>
                    <td>
                        @if($relatorio->status === 'finalizado')
                            <span class="status-badge status-ativo">Finalizado</span>
                        @else
                            <span class="status-badge status-pendente">Rascunho</span>
                        @endif
                    </td>
                    <td>
                        <div class="acoes" style="justify-content:flex-end;">
                            <a href="{{ route('relatorios.show', $relatorio) }}" class="action-btn edit">Ver</a>
                            <a href="{{ route('relatorios.edit', $relatorio) }}" class="action-btn edit">Editar</a>
                            <form action="{{ route('relatorios.destroy', $relatorio) }}" method="POST"
                                  onsubmit="return confirm('Remover este relatório? Esta ação não pode ser desfeita.');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn danger">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            @if(request('search'))
                                Nenhum relatório encontrado para “{{ request('search') }}”.
                            @else
                                Nenhum relatório por aqui ainda.<br>
                                <a href="{{ route('relatorios.create') }}" style="color:var(--primary);font-weight:600;">Criar o primeiro →</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($relatorios, 'links'))
        <div style="margin-top:18px;">{{ $relatorios->appends(request()->query())->links() }}</div>
    @endif

</div>
@endsection
