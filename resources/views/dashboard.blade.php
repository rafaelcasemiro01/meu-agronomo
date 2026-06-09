<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Meu Agronomo')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-body">

    <aside class="barra-lateral">
        <div class="logo-dashboard">
            <img src="{{ asset('images/logo.png') }}" alt="logo-meu-agronomo">
            <h1>Meu Agrônomo</h1>
        </div>

        <nav>
            <ul>
                <li><a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">Início</a></li>

                <li class="menu-drop">
                    <a class="toggle">Meu Perfil <i class="fas fa-chevron-down dropdown-arrow"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ route('perfil.info') }}" class="{{ Request::routeIs('perfil.info') ? 'active' : '' }}">Informações Pessoais</a></li>
                        <li><a href="{{ route('perfil.senha') }}" class="{{ Request::routeIs('perfil.senha') ? 'active' : '' }}">Alterar Senha</a></li>
                    </ul>
                </li>

                <li class="menu-drop">
                    <a class="toggle">Clientes <i class="fas fa-chevron-down dropdown-arrow"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ route('clientes.create') }}" class="{{ Request::routeIs('clientes.create') ? 'active' : '' }}">Adicionar cliente</a></li>
                        <li><a href="{{ route('clientes.index') }}" class="{{ Request::routeIs('clientes.index') || Request::routeIs('clientes.edit') ? 'active' : '' }}">Lista de clientes</a></li>
                        <li><a href="#">Relatórios</a></li>
                    </ul>
                </li>

                <li class="menu-drop">
                    <a class="toggle">Visita Técnica <i class="fas fa-chevron-down dropdown-arrow"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ route('visitas.agendar') }}" class="{{ Request::routeIs('visitas.agendar') ? 'active' : '' }}">Agendar Visita</a></li>
                        {{-- ROTA CORRIGIDA AQUI --}}
                        <li><a href="{{ route('visitas.minhas') }}" class="{{ Request::routeIs('visitas.minhas') ? 'active' : '' }}">Minhas Visitas</a></li>
                        <li><a href="#" class="{{ Request::routeIs('visitas.relatorios') ? 'active' : '' }}">Relatórios de Visitas</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="conteudo-principal">
        <header class="topo">
            <h2>Olá, {{ Auth::user()->name }}!</h2>
            <div class="search-logout-area">
                {{-- A ABA DE PESQUISAR FOI REMOVIDA DAQUI --}}
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout">Sair</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            </div>
        </header>

        {{-- AQUI É ONDE O CONTEÚDO ESPECÍFICO DE CADA PÁGINA SERÁ INJETADO --}}
        @yield('main-content')
    </main>

    {{-- Script JavaScript para os menus (deve estar ANTES de @stack('scripts')) --}}
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle');

            toggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const menu = toggle.parentElement;
                    const submenu = menu.querySelector('.submenu');

                    document.querySelectorAll('.menu-drop').forEach(m => {
                        if (m !== menu) {
                            m.classList.remove('open');
                            const sm = m.querySelector('.submenu');
                            if (sm) {
                                sm.style.maxHeight = null;
                                sm.style.opacity = 0;
                                sm.style.paddingTop = 0;
                                sm.style.paddingBottom = 0;
                            }
                        }
                    });

                    if (menu.classList.contains('open')) {
                        menu.classList.remove('open');
                        submenu.style.maxHeight = null;
                        submenu.style.opacity = 0;
                        submenu.style.paddingTop = 0;
                        submenu.style.paddingBottom = 0;
                    } else {
                        menu.classList.add('open');

                        submenu.style.display = 'block';
                        const height = submenu.scrollHeight;
                        submenu.style.maxHeight = '0px';
                        submenu.style.opacity = 0;
                        submenu.style.paddingTop = '0px';
                        submenu.style.paddingBottom = '0px';

                        requestAnimationFrame(() => {
                            submenu.style.transition = 'max-height 0.5s ease, opacity 0.5s ease, padding 0.3s ease';
                            submenu.style.maxHeight = height + 'px';
                            submenu.style.opacity = 1;
                            submenu.style.paddingTop = '5px';
                            submenu.style.paddingBottom = '5px';
                        });
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
