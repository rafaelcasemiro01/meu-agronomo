{{-- resources/views/visitas/minhas.blade.php --}}
@extends('dashboard')

@section('page-title', 'Meu Agronomo - Minhas Visitas')

@section('main-content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Minhas Visitas Técnicas</h1>
            <a href="{{ route('visitas.agendar') }}" class="btn btn-primary">
                Agendar Nova Visita
            </a>
        </div>

        {{-- Exibe mensagem de sucesso --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Exibe mensagem de erro --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- NAVEGAÇÃO POR ABAS PARA FILTRAR VISITAS --}}
        <ul class="nav nav-pills mb-3" id="visitasTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') == '' || request('status') == 'agendada' ? 'active' : '' }}"
                   id="agendadas-tab" href="{{ route('visitas.minhas', ['status' => 'agendada']) }}" role="tab" aria-controls="agendadas" aria-selected="true">Agendadas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') == 'realizada' ? 'active' : '' }}"
                   id="realizadas-tab" href="{{ route('visitas.minhas', ['status' => 'realizada']) }}" role="tab" aria-controls="realizadas" aria-selected="false">Realizadas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') == 'cancelada' ? 'active' : '' }}"
                   id="canceladas-tab" href="{{ route('visitas.minhas', ['status' => 'cancelada']) }}" role="tab" aria-controls="canceladas" aria-selected="false">Canceladas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') == 'todas' ? 'active' : '' }}"
                   id="todas-tab" href="{{ route('visitas.minhas', ['status' => 'todas']) }}" role="tab" aria-controls="todas" aria-selected="false">Todas</a>
            </li>
        </ul>

        @if(isset($visitas) && $visitas->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Cliente</th>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Local</th>
                            <th scope="col">Observações</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitas as $visita)
                            <tr>
                                <td>{{ $visita->cliente->nome }}</td>
                                <td>{{ \Carbon\Carbon::parse($visita->data_visita)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($visita->hora_visita)->format('H:i') }}</td>
                                <td>{{ $visita->local_visita ?? 'N/A' }}</td>
                                <td>{{ $visita->observacoes ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $badgeClass = '';
                                        switch ($visita->status) {
                                            case 'agendada':
                                                $badgeClass = 'bg-info';
                                                break;
                                            case 'cancelada':
                                                $badgeClass = 'bg-danger';
                                                break;
                                            case 'realizada':
                                                $badgeClass = 'bg-success';
                                                break;
                                            default:
                                                $badgeClass = 'bg-secondary';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($visita->status) }}</span>
                                </td>
                                <td>
                                    @if($visita->status == 'agendada')
                                      <button type="button" class="btn btn-sm btn-success" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#realizarVisitaModal" data-visita-id="{{ $visita->id }}">
                                        Realizado
                                       </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelarVisitaModal" data-visita-id="{{ $visita->id }}">
                                            Cancelar
                                        </button>
                                    @elseif($visita->status == 'realizada')
                                        <button type="button" class="btn btn-sm btn-outline-success" disabled>
                                            Realizada
                                        </button>
                                    @elseif($visita->status == 'cancelada')
                                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                                            Cancelada
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                                            {{ ucfirst($visita->status) }}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $visitas->appends(['status' => request('status')])->links() }}
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Nenhuma visita técnica encontrada para o status selecionado. <a href="{{ route('visitas.agendar') }}" class="alert-link">Agende uma nova visita aqui!</a>
            </div>
        @endif
    </div>

    {{-- Modal de Confirmação de Realização --}}
    <div class="modal fade" id="realizarVisitaModal" tabindex="-1" aria-labelledby="realizarVisitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="realizarVisitaModalLabel">Confirmar Realização da Visita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja confirmar esta visita como realizada? Esta ação não pode ser desfeita.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <form id="realizarVisitaForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Confirmar Realização</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Confirmação de Cancelamento (Já existia) --}}
    <div class="modal fade" id="cancelarVisitaModal" tabindex="-1" aria-labelledby="cancelarVisitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelarVisitaModalLabel">Confirmar Cancelamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja cancelar esta visita técnica? Esta ação não pode ser desfeita.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <form id="cancelarVisitaForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">Confirmar Cancelamento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lógica para o Modal de Realização
        var realizarVisitaModal = document.getElementById('realizarVisitaModal');
        if (realizarVisitaModal) {
            realizarVisitaModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var visitaId = button.getAttribute('data-visita-id');
                var form = realizarVisitaModal.querySelector('#realizarVisitaForm');
                form.action = '{{ url("visitas") }}/' + visitaId + '/realizar'; // Nova rota
            });
        }

        // Lógica para o Modal de Cancelamento (Já existia)
        var cancelarVisitaModal = document.getElementById('cancelarVisitaModal');
        if (cancelarVisitaModal) {
            cancelarVisitaModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var visitaId = button.getAttribute('data-visita-id');
                var form = cancelarVisitaModal.querySelector('#cancelarVisitaForm');
                form.action = '{{ url("visitas") }}/' + visitaId + '/cancelar';
            });
        }
    });
</script>
@endpush
