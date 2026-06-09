@extends('dashboard') {{-- Usa o layout principal da dashboard --}}

@section('page-title', 'Meus Clientes - Meu Agrônomo') {{-- Título da aba --}}

@section('main-content')
    <header class="topo">
        <h2>Lista de Clientes</h2>
        <div class="search-logout-area">
            {{-- FORMULÁRIO DE PESQUISA --}}
            <form action="{{ route('clientes.index') }}" method="GET" class="search-input-form">
                <div class="search-input">
                    <i class="fas fa-search icon-search"></i>
                    <input type="text" name="search" placeholder="Pesquisar clientes" value="{{ request('search') }}">
                </div>
                {{-- Botão oculto para enviar ao apertar Enter --}}
                <button type="submit" style="display: none;"></button>
                {{-- Mantém o status atual ao pesquisar --}}
                <input type="hidden" name="status" value="{{ $status }}">
            </form>

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="logout">
                Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </header>

    <section class="clientes-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            {{-- Filtros de Status --}}
            <a href="{{ route('clientes.index', ['status' => 'ativo', 'search' => request('search')]) }}"
               class="btn-filtro {{ $status === 'ativo' ? 'active-filtro' : '' }}">Ativos</a>
            <a href="{{ route('clientes.index', ['status' => 'inativo', 'search' => request('search')]) }}"
               class="btn-filtro {{ $status === 'inativo' ? 'active-filtro' : '' }}">Inativos</a>
            <a href="{{ route('clientes.index', ['status' => 'todos', 'search' => request('search')]) }}"
               class="btn-filtro {{ $status === 'todos' ? 'active-filtro' : '' }}">Todos</a>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn-adicionar">Adicionar Cliente</a>
    </section>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section>
        <table class="tabela-clientes">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Cidade</th>
                    <th>Contato</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->cpf }}</td>
                        <td>{{ $cliente->cidade }}</td>
                        <td>{{ $cliente->contato }}</td>
                        <td>
                            <span class="badge {{ $cliente->status ? 'status-ativo' : 'status-inativo' }}">
                                {{ $cliente->status ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="acoes">
                            <a href="{{ route('clientes.edit', $cliente->id) }}">Editar</a>
                            @if ($cliente->status)
                                {{-- Botão Inativar --}}
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inativar-btn" onclick="return confirm('Tem certeza que deseja inativar este cliente?');">Inativar</button>
                                </form>
                            @else
                                {{-- Botão Reativar --}}
                                <form action="{{ route('clientes.activate', $cliente->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="reativar-btn" onclick="return confirm('Tem certeza que deseja reativar este cliente?');">Reativar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            @if(request('search'))
                                Nenhum cliente encontrado para "{{ request('search') }}" com status "{{ $status }}".
                            @else
                                Nenhum cliente registrado.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Paginação opcional se usar paginate() --}}
        {{-- {{ $clientes->appends(['search' => request('search'), 'status' => $status])->links() }} --}}
    </section>
@endsection
