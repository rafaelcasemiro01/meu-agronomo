{{--
    VISITAS — AGENDAR
    Rota: visitas.agendar (GET)  ·  Envia para: visitas.store (POST)
    Variável esperada: $clientes (para o select)
    Campos: cliente_id, tipo, data, hora, duracao, observacoes
--}}
@extends('dashboard')
@section('page-title', 'Agendar visita — Meu Agrônomo')
@section('topbar-title', 'Agendar visita')

@section('main-content')
<div class="ma-page">

    <a href="{{ route('visitas.minhas') }}" class="btn-back" style="margin-bottom:14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Minhas visitas
    </a>

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Visita técnica</div>
            <h2>Agendar visita</h2>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="form-page">
        <div class="form-card">
            <form action="{{ route('visitas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Cliente</label>
                    <select name="cliente_id" required>
                        <option value="">Selecione o cliente…</option>
                        @forelse(($clientes ?? []) as $cliente)
                            <option value="{{ $cliente->id ?? '' }}" {{ old('cliente_id') == ($cliente->id ?? '') ? 'selected' : '' }}>{{ $cliente->nome ?? '—' }}</option>
                        @empty
                            <option value="" disabled>Nenhum cliente cadastrado</option>
                        @endforelse
                    </select>
                    @error('cliente_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Tipo de visita</label>
                    <select name="tipo">
                        @foreach(['Avaliação de pragas','Análise de solo','Recomendação de adubação','Monitoramento','Vistoria de irrigação','Diagnóstico fitossanitário'] as $t)
                            <option value="{{ $t }}" {{ old('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Data</label>
                    <input type="date" name="data" value="{{ old('data') }}" required>
                    @error('data')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Horário</label>
                    <input type="time" name="hora" value="{{ old('hora') }}">
                </div>

                <div class="form-group">
                    <label>Duração estimada</label>
                    <select name="duracao">
                        @foreach(['1h','1h30','2h','3h','Dia inteiro'] as $d)
                            <option value="{{ $d }}" {{ old('duracao') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Observações</label>
                    <textarea name="observacoes" placeholder="Pontos a verificar, materiais a levar…">{{ old('observacoes') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('visitas.minhas') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Confirmar agendamento</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
