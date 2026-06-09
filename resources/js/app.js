/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// Importa Bootstrap JS -- ESTA É A LINHA QUE FALTAVA!
import 'bootstrap'; // Importa a biblioteca Bootstrap (inclui o bundle completo JS)

// Importa Flatpickr e a localização em português
import flatpickr from "flatpickr";
import { Portuguese } from "flatpickr/dist/l10n/pt.js";

// Importa suas máscaras. O masks.js já tem seu próprio 'DOMContentLoaded'
// para as máscaras, então ele se inicializará sozinho quando carregado.
import './masks.js';

// Importa createApp para o Vue (mantenha se você usa Vue, caso contrário pode remover)
import { createApp } from 'vue';

const app = createApp({});
// Importe seus componentes Vue aqui, se houver:
// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);
app.mount('#app');


// =========================================================================
// !!! INÍCIO DO CÓDIGO JS GLOBAL PARA FLATPCIKR, AUTOCOMPLETE E MENU LATERAL !!!
// Esta parte do código vai rodar quando o DOM estiver completamente carregado.
// =========================================================================
document.addEventListener('DOMContentLoaded', () => {

    // ---------------------------------------------------------------------
    // 1. Inicialização do Flatpickr
    // ---------------------------------------------------------------------
    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d",
        locale: Portuguese, // Use o nome importado aqui
        minDate: "today",
        altInput: true,
        altFormat: "d/m/Y",
        onClose: function(selectedDates, dateStr, instance) {
            const originalInput = instance.altInput.previousElementSibling;
            if (originalInput) {
                originalInput.value = dateStr;
            }
        }
    });

    // ---------------------------------------------------------------------
    // 2. Lógica para autocomplete de cliente (para a view 'visitas.agendar')
    // ---------------------------------------------------------------------
    const clienteSearchInput = document.getElementById('cliente_search');
    const clienteIdInput = document.getElementById('cliente_id');
    const localVisitaInput = document.getElementById('local_visita');
    const clientesList = document.getElementById('clientes_list');

    if (clienteSearchInput && clientesList) {
        // Assume que a variável `clientesDataForAutocomplete` é definida globalmente
        // na view `agendar.blade.php` ANTES de `app.js` ser carregado.
        let clientesData = window.clientesDataForAutocomplete || [];

        clienteSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            clientesList.innerHTML = ''; // Limpa a lista anterior

            if (searchTerm.length > 0) {
                const filteredClientes = clientesData.filter(cliente =>
                    cliente.nome.toLowerCase().includes(searchTerm) ||
                    (cliente.nome_propriedade && cliente.nome_propriedade.toLowerCase().includes(searchTerm)) ||
                    (cliente.endereco_completo && cliente.endereco_completo.toLowerCase().includes(searchTerm))
                );

                filteredClientes.forEach(cliente => {
                    const li = document.createElement('li');
                    li.textContent = `${cliente.nome} (${cliente.nome_propriedade ? cliente.nome_propriedade + ' - ' : ''}${cliente.cidade}/${cliente.estado})`;
                    li.dataset.clienteId = cliente.id;
                    li.dataset.localVisita = cliente.endereco_completo;
                    li.addEventListener('click', function() {
                        clienteSearchInput.value = cliente.nome;
                        clienteIdInput.value = cliente.id;
                        localVisitaInput.value = cliente.endereco_completo;
                        clientesList.innerHTML = ''; // Limpa a lista após seleção
                    });
                    clientesList.appendChild(li);
                });
            }
        });

        // Fechar lista de sugestões ao clicar fora
        document.addEventListener('click', function(e) {
            if (!clienteSearchInput.contains(e.target) && !clientesList.contains(e.target)) {
                clientesList.innerHTML = '';
            }
        });
    }

    // ---------------------------------------------------------------------
    // 3. Lógica para o Menu Lateral (expandir/recolher e marcar ativo)
    // ---------------------------------------------------------------------

    // Lógica para expandir/recolher os dropdowns ao CLICAR
    document.querySelectorAll('.menu-drop .dropdown-toggle').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();

            const parentLi = this.closest('.menu-drop');

            if (parentLi) {
                // Fecha OUTROS submenus abertos (comportamento de acordeão)
                document.querySelectorAll('.menu-drop.open').forEach(function(openMenu) {
                    if (openMenu !== parentLi) {
                        openMenu.classList.remove('open');
                        // Remove o destaque do toggle principal de menus que estão sendo fechados
                        openMenu.querySelector('.dropdown-toggle')?.classList.remove('active-toggle-on-open');
                    }
                });

                // Alterna o estado 'open' do menu clicado
                parentLi.classList.toggle('open');

                // Adiciona/Remove a classe de destaque no dropdown-toggle principal ao abrir/fechar
                this.classList.toggle('active-toggle-on-open', parentLi.classList.contains('open'));
            }
        });
    });


    // Lógica para marcar o link ativo na barra lateral no carregamento da página
    const currentPath = window.location.pathname;
    document.querySelectorAll('.barra-lateral nav ul li a').forEach(link => {
        const linkHref = new URL(link.href).pathname;

        const cleanCurrentPath = currentPath.endsWith('/') && currentPath.length > 1 ? currentPath.slice(0, -1) : currentPath;
        const cleanLinkHref = linkHref.endsWith('/') && linkHref.length > 1 ? linkHref.slice(0, -1) : linkHref;

        const isVisitasRoute = cleanLinkHref.startsWith('/visitas') || cleanCurrentPath.startsWith('/visitas');
        const isClientesRoute = cleanLinkHref.startsWith('/clientes') || cleanCurrentPath.startsWith('/clientes');

        if (cleanLinkHref === cleanCurrentPath || (isVisitasRoute && linkHref.includes('/visitas')) || (isClientesRoute && linkHref.includes('/clientes'))) {
            link.classList.add('active'); // Marca o link da página atual como 'active'

            // Se o link ativo estiver dentro de um submenu, expande o menu pai
            const parentMenuDrop = link.closest('.menu-drop');
            if (parentMenuDrop) {
                parentMenuDrop.classList.add('open');
                // Garante que o toggle pai também receba o destaque
                parentMenuDrop.querySelector('.dropdown-toggle')?.classList.add('active-toggle-on-open');
            }
        }
    });
});
