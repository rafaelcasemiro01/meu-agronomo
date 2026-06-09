{{-- resources/views/home.blade.php --}}
@extends('dashboard') {{-- ESTENDE O SEU LAYOUT BASE --}}

@section('page-title', 'Meu Agronomo - Início')

@section('main-content')
    <section class="atalhos">
        <h3>Meus atalhos</h3>
        <div class="quadro-atalhos">
            <a href="{{ route('clientes.create') }}" class="atalho">Adicionar Cliente</a>
            <div class="atalho">Relatório de cliente</div>
        </div>
    </section>

    <section class="principais-clientes-lista">
        <h3>Principais clientes</h3>
        <ul>
            @forelse ($clientes as $cliente)
                <li>
                    <span>{{ $cliente->nome }}</span>
                    <span>{{ $cliente->cpf }}</span>
                    <span>{{ $cliente->visitas }} visitas</span>
                </li>
            @empty
                <li>Nenhum cliente cadastrado ainda.</li>
            @endforelse
        </ul>
    </section>

    {{-- A SEÇÃO "MEUS MARCADORES" FOI REMOVIDA DAQUI --}}

@endsection
