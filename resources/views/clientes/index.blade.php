@extends('dashboard')
@section('page-title', 'Clientes — Meu Agrônomo')
@section('topbar-title', 'Clientes')

@section('main-content')
<div class="ma-page">

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Gestão</div>
            <h2>Clientes</h2>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn-add">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Adicionar cliente
        </a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    @php $statusAtual = request('status', 'ativo'); @endphp
    <div class="filter-bar">
        <a href="{{ route('clientes.index', array_filter(['status' => 'ativo', 'search' => request('search')])) }}"
           class="filter-btn {{ $statusAtual == 'ativo' ? 'active-filtro' : '' }}">Ativos</a>
        <a href="{{ route('clientes.index', array_filter(['status' => 'inativo', 'search' => request('search')])) }}"
           class="filter-btn {{ $statusAtual == 'inativo' ? 'active-filtro' : '' }}">Inativos</a>
        <a href="{{ route('clientes.index', array_filter(['status' => 'todos', 'search' => request('search')])) }}"
           class="filter-btn {{ $statusAtual == 'todos' ? 'active-filtro' : '' }}">Todos</a>
    </div>

    <div class="tabela-wrapper">
        <table class="tabela-clientes">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Propriedade</th>
                    <th>Contato</th>
                    <th>Status</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>
                        <div class="cliente-info">
                            <div class="cliente-avatar">{{ strtoupper(\Illuminate\Support\Str::substr($cliente->nome, 0, 2)) }}</div>
                            <div>
                                <div class="cliente-nome">{{ $cliente->nome }}</div>
                                <div class="cliente-cpf">{{ $cliente->cpf }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:13.5px;">{{ $cliente->nome_propriedade }}</div>
                        <div class="cliente-cpf">{{ $cliente->cidade }}/{{ $cliente->estado }} · {{ rtrim(rtrim(number_format($cliente->area_total_ha, 2, ',', '.'), '0'), ',') }} ha</div>
                    </td>
                    <td>{{ $cliente->contato }}</td>
                    <td>
                        @if($cliente->status)
                            <span class="status-badge status-ativo">Ativo</span>
                        @else
                            <span class="status-badge status-inativo">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <div class="acoes" style="justify-content:flex-end;">
                            <a href="{{ route('clientes.show', $cliente) }}" class="action-btn edit">Ver</a>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="action-btn edit">Editar</a>
                            @if($cliente->status)
                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                      onsubmit="return confirm('Inativar este cliente?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn danger">Inativar</button>
                                </form>
                            @else
                                <form action="{{ route('clientes.activate', $cliente) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn edit">Reativar</button>
                                </form>
                            @endif
                            <form action="{{ route('clientes.force', $cliente) }}" method="POST"
                                  onsubmit="return confirm('EXCLUIR DEFINITIVAMENTE este cliente?\n\nEsta ação remove o cliente e TODAS as suas visitas e relatórios. Não pode ser desfeita.');" style="display:inline;">
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
                                Nenhum cliente encontrado para “{{ request('search') }}”.
                            @else
                                Nenhum cliente cadastrado ainda.<br>
                                <a href="{{ route('clientes.create') }}" style="color:var(--primary);font-weight:600;">Adicionar o primeiro →</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($clientes, 'links'))
        <div style="margin-top:18px;">{{ $clientes->appends(request()->query())->links() }}</div>
    @endif

</div>
@endsection
