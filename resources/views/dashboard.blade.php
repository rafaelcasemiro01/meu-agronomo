<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Meu Agrônomo')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-body">

    {{-- ── SIDEBAR ─────────────────────────────────────────── --}}
    <aside class="barra-lateral">

        <div class="logo-dashboard">
            <img src="{{ asset('images/logo.png') }}" alt="Meu Agrônomo">
            <h1>Meu Agrônomo</h1>
        </div>

        <div class="sidebar-divider"></div>

        <nav>
            <ul>
                {{-- Início --}}
                <li class="sidebar-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <div class="sidebar-link-icon">
                            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                        <span class="sidebar-link-text">Início</span>
                    </a>
                </li>

                {{-- Meu Perfil --}}
                <li class="sidebar-item menu-drop">
                    <a class="sidebar-link toggle">
                        <div class="sidebar-link-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <span class="sidebar-link-text">Meu Perfil</span>
                        <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('perfil.info') }}" class="{{ Request::routeIs('perfil.info') ? 'active' : '' }}">Informações Pessoais</a></li>
                        <li><a href="{{ route('perfil.senha') }}" class="{{ Request::routeIs('perfil.senha') ? 'active' : '' }}">Alterar Senha</a></li>
                    </ul>
                </li>

                {{-- Clientes --}}
                <li class="sidebar-item menu-drop">
                    <a class="sidebar-link toggle">
                        <div class="sidebar-link-icon">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <span class="sidebar-link-text">Clientes</span>
                        <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('clientes.create') }}" class="{{ Request::routeIs('clientes.create') ? 'active' : '' }}">Adicionar cliente</a></li>
                        <li><a href="{{ route('clientes.index') }}" class="{{ Request::routeIs('clientes.index') || Request::routeIs('clientes.edit') ? 'active' : '' }}">Lista de clientes</a></li>
                        <li><a href="#">Relatórios</a></li>
                    </ul>
                </li>

                {{-- Visita Técnica --}}
                <li class="sidebar-item menu-drop">
                    <a class="sidebar-link toggle">
                        <div class="sidebar-link-icon">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <span class="sidebar-link-text">Visita Técnica</span>
                        <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('visitas.agendar') }}" class="{{ Request::routeIs('visitas.agendar') ? 'active' : '' }}">Agendar Visita</a></li>
                        <li><a href="{{ route('visitas.minhas') }}" class="{{ Request::routeIs('visitas.minhas') ? 'active' : '' }}">Minhas Visitas</a></li>
                        <li><a href="#" class="{{ Request::routeIs('visitas.relatorios') ? 'active' : '' }}">Relatórios</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        {{-- Rodapé --}}
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="sidebar-link" style="color: rgba(255,255,255,0.4);">
                <div class="sidebar-link-icon">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </div>
                <span class="sidebar-link-text">Sair</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>

    </aside>

    {{-- ── CONTEÚDO ─────────────────────────────────────────── --}}
    <main class="conteudo-principal">

        <header class="topo">
            <h2>{{ Auth::user()->name }}</h2>
            <div class="topo-right">
                <div class="user-avatar" title="{{ Auth::user()->name }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        @yield('main-content')

    </main>

    {{-- Scripts sidebar --}}
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const item = toggle.closest('.menu-drop');
                    const isOpen = item.classList.contains('open');
                    document.querySelectorAll('.menu-drop.open').forEach(m => m.classList.remove('open'));
                    if (!isOpen) item.classList.add('open');
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
