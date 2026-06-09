@extends('dashboard')

@section('page-title', 'Agendar Visita Técnica')

{{-- Mover CSS do Flatpickr para o head usando @push('styles') --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
{{-- Link para Font Awesome (se ainda não estiver global) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('main-content')
<div class="form-agendar-visita">
    <h1>Agendar Nova Visita Técnica</h1>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Mensagem de erros --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('visitas.store') }}" method="POST" class="form-grid-content">
        @csrf

        <div class="form-left">
            {{-- Cliente (com preenchimento automático de endereço) --}}
            <div class="form-group-custom">
                <label for="cliente_id">Selecione o Cliente</label>
                <select name="cliente_id" id="cliente_id" required>
                    <option value="">Selecione o cliente</option>
                    @foreach($clientes as $cliente)
                        {{-- ** IMPORTANTE: VERIFIQUE AQUI! O $cliente->endereco DEVE SER O NOME REAL DO CAMPO NO SEU MODELO CLIENTE ** --}}
                        {{-- Exemplo: se o campo é 'address', mude para $cliente->address --}}
                        <option value="{{ $cliente->id }}"
                                data-address="{{ $cliente->endereco ?? 'Endereço não cadastrado' }}"
                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }} - {{ $cliente->nome_propriedade ?? 'Sem propriedade' }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Local da Visita (preenchido automaticamente) --}}
            <div class="form-group-custom">
                <label for="local_visita">Local da Visita</label>
                <input type="text" name="local_visita" id="local_visita" value="{{ old('local_visita') }}" placeholder="Endereço da propriedade ou local específico">
                @error('local_visita') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Observações --}}
            <div class="form-group-custom">
                <label for="observacoes">Observações</label>
                <textarea name="observacoes" id="observacoes" rows="4" placeholder="Adicione detalhes importantes sobre a visita...">{{ old('observacoes') }}</textarea>
                @error('observacoes') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-right">
            {{-- Data da Visita (Flatpickr Inline) --}}
            <div class="form-group-custom flatpickr-inline-group">
                <label for="flatpickr-display-label">Selecione a Data</label>
                {{-- Input hidden que guardará o valor real da data selecionada para o backend --}}
                <input type="hidden" name="data_visita" id="data_visita_hidden" value="{{ old('data_visita') ?: now()->format('Y-m-d') }}" required>
                {{-- Div onde o Flatpickr irá renderizar o calendário inline --}}
                <div id="flatpickr-inline-calendar"></div>
                @error('data_visita') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Hora da Visita (Flatpickr Time Picker) --}}
            <div class="form-group-custom flatpickr-time-group">
                <label for="hora_visita">Selecione a Hora</label>
                <input type="text" name="hora_visita" id="hora_visita" value="{{ old('hora_visita') ?: now()->format('H:i') }}" required>
                @error('hora_visita') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Botões --}}
        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn-cancelar">Cancelar</a>
            <button type="submit" class="btn-agendar">Agendar Visita</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
{{-- Scripts do Flatpickr (agora APENAS JS aqui) --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Lógica de preenchimento automático do endereço ---
        const clienteSelect = document.getElementById('cliente_id');
        const localVisitaInput = document.getElementById('local_visita');

        // Função para preencher o endereço
        function fillAddress() {
            const selectedOption = clienteSelect.options[clienteSelect.selectedIndex];
            const address = selectedOption.getAttribute('data-address');
            if (address) {
                localVisitaInput.value = address;
            } else {
                localVisitaInput.value = ''; // Limpa se não houver endereço
            }
        }

        clienteSelect.addEventListener('change', fillAddress);

        // Preenche na carga inicial da página se houver um cliente já selecionado (via old('cliente_id'))
        // Garante que o endereço seja preenchido se o old('cliente_id') estava setado
        if (clienteSelect.value) {
            fillAddress();
        }


        // --- Inicialização do Flatpickr para o calendário INLINE (Data) ---
        const flatpickrContainer = document.getElementById('flatpickr-inline-calendar');
        const hiddenDateInput = document.getElementById('data_visita_hidden');

        flatpickr(flatpickrContainer, {
            inline: true, // Faz o calendário ser sempre visível dentro do container
            dateFormat: "Y-m-d", // Formato para o valor do input hidden
            minDate: "today", // Impede seleção de datas passadas
            defaultDate: hiddenDateInput.value || "today", // Usa o valor do input hidden, ou "today" se vazio
            locale: "pt", // Idioma português
            wrap: false,
            altInput: true, // Cria um input alternativo para formatação de exibição
            altFormat: "D, M j", // Ex: Seg, Ago 17
            onReady: function(selectedDates, dateStr, instance) {
                const headerDisplayLabel = document.createElement('div');
                headerDisplayLabel.classList.add('flatpickr-header-display-label');
                headerDisplayLabel.textContent = instance.altInput.value;
                const parentGroup = document.querySelector('.flatpickr-inline-group');
                const labelElement = parentGroup.querySelector('label');
                if (labelElement) {
                    labelElement.parentNode.insertBefore(headerDisplayLabel, labelElement.nextSibling);
                }
                instance.altInput.style.display = 'none';
            },
            onChange: function(selectedDates, dateStr, instance) {
                hiddenDateInput.value = dateStr;
                const headerDisplayLabel = document.querySelector('.flatpickr-header-display-label');
                if (headerDisplayLabel) {
                    headerDisplayLabel.textContent = instance.altInput.value;
                }
            }
        });

        // --- Inicialização do Flatpickr para o seletor de HORA ---
        flatpickr("#hora_visita", {
            enableTime: true,
            noCalendar: true, // Apenas seletor de tempo
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "{{ old('hora_visita') ?: now()->format('H:i') }}",
            locale: "pt"
        });
    });
</script>
@endpush
