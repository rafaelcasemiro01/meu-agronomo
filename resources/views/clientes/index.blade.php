{{--
    CLIENTES — LISTA
    Rota: clientes.index  (GET)   ·  Variável esperada: $clientes (coleção/paginator)
    Rotas usadas: clientes.create, clientes.edit, clientes.destroy
    Campos lidos (ajuste ao seu model): ->id, ->nome, ->cpf, ->telefone, ->cidade, ->uf, ->status
--}}
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

    <div class="filter-bar">
        <a href="{{ route('clientes.index') }}" class="filter-btn {{ !request('status') ? 'active-filtro' : '' }}">Todos</a>
        <a href="{{ route('clientes.index', ['status' => 'ativo']) }}" class="filter-btn {{ request('status') == 'ativo' ? 'active-filtro' : '' }}">Ativos</a>
        <a href="{{ route('clientes.index', ['status' => 'inativo']) }}" class="filter-btn {{ request('status') == 'inativo' ? 'active-filtro' : '' }}">Inativos</a>
    </div>

    <div class="tabela-wrapper">
        <table class="tabela-clientes">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Contato</th>
                    <th>Localização</th>
                    <th>Status</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse(($clientes ?? []) as $cliente)
                <tr>
                    <td>
                        <div class="cliente-info">
                            <div class="cliente-avatar">{{ strtoupper(substr($cliente->nome ?? 'CL', 0, 2)) }}</div>
                            <div>
                                <div class="cliente-nome">{{ $cliente->nome ?? '—' }}</div>
                                <div class="cliente-cpf">{{ $cliente->cpf ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $cliente->telefone ?? '—' }}</td>
                    <td>{{ $cliente->cidade ?? '—' }}{{ !empty($cliente->uf) ? '/'.$cliente->uf : '' }}</td>
                    <td>
                        @php $st = strtolower($cliente->status ?? 'ativo'); @endphp
                        <span class="status-badge status-{{ $st }}">{{ ucfirst($st) }}</span>
                    </td>
                    <td>
                        <div class="acoes" style="justify-content:flex-end;">
                            <a href="{{ route('clientes.edit', $cliente->id ?? 0) }}" class="action-btn edit">Editar</a>
                            <form action="{{ route('clientes.destroy', $cliente->id ?? 0) }}" method="POST"
                                  onsubmit="return confirm('Remover este cliente?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn danger">Remover</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            Nenhum cliente cadastrado ainda.<br>
                            <a href="{{ route('clientes.create') }}" style="color:var(--primary);font-weight:600;">Adicionar o primeiro →</a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($clientes) && is_object($clientes) && method_exists($clientes, 'links'))
        <div style="margin-top:18px;">{{ $clientes->links() }}</div>
    @endif

</div>
@endsection
