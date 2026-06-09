<!DOCTYPE html>
<html lang="pt-br" data-theme="{{ Cookie::get('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Meu Agrônomo')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body class="dashboard-body">

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="barra-lateral" id="sidebar">

        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="22" x2="12" y2="10"/>
                        <path d="M12 10C12 10 8 7 8 4a4 4 0 0 1 8 0c0 3-4 6-4 6z"/>
                        <path d="M12 14C14 12 17 13 18 11"/>
                        <path d="M12 14C10 12 7 13 6 11"/>
                    </svg>
                </div>
                <div>
                    <div class="sidebar-brand-name">Meu Agrônomo</div>
                    <div class="sidebar-brand-sub">Gestão agrícola</div>
                </div>
            </div>
            <button class="sidebar-close" id="sidebarClose" aria-label="Fechar menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">

            <a href="{{ route('dashboard') }}" class="sidebar-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Início
            </a>

            <div class="sidebar-section-label">Gestão</div>

            <div class="menu-drop">
                <a class="sidebar-link toggle">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Clientes
                    <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('clientes.create') }}" class="{{ Request::routeIs('clientes.create') ? 'active' : '' }}">Adicionar cliente</a></li>
                    <li><a href="{{ route('clientes.index') }}" class="{{ Request::routeIs('clientes.index') || Request::routeIs('clientes.edit') ? 'active' : '' }}">Lista de clientes</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </div>

            <div class="menu-drop">
                <a class="sidebar-link toggle">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Visita Técnica
                    <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('visitas.agendar') }}" class="{{ Request::routeIs('visitas.agendar') ? 'active' : '' }}">Agendar Visita</a></li>
                    <li><a href="{{ route('visitas.minhas') }}" class="{{ Request::routeIs('visitas.minhas') ? 'active' : '' }}">Minhas Visitas</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </div>

            <div class="sidebar-section-label">Conta</div>

            <div class="menu-drop">
                <a class="sidebar-link toggle">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Meu Perfil
                    <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('perfil.info') }}" class="{{ Request::routeIs('perfil.info') ? 'active' : '' }}">Informações Pessoais</a></li>
                    <li><a href="{{ route('perfil.senha') }}" class="{{ Request::routeIs('perfil.senha') ? 'active' : '' }}">Alterar Senha</a></li>
                </ul>
            </div>

        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="sidebar-logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>

    </aside>

    <main class="conteudo-principal">

        <header class="topo">
            <div class="topo-left">
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="topo-brand">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color: var(--g-600)">
                        <line x1="12" y1="22" x2="12" y2="10"/>
                        <path d="M12 10C12 10 8 7 8 4a4 4 0 0 1 8 0c0 3-4 6-4 6z"/>
                    </svg>
                    Meu Agrônomo
                </div>
            </div>
            <div class="topo-right">
                <button class="dark-toggle" id="darkToggle" aria-label="Alternar tema">
                    <svg id="iconSun" viewBox="0 0 24 24" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    <svg id="iconMoon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
                <div class="user-avatar" title="{{ Auth::user()->name }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        @yield('main-content')

    </main>

    <script defer>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() { sidebar.classList.add('open'); overlay.classList.add('visible'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('visible'); document.body.style.overflow = ''; }

        toggleBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.toggle').forEach(t => {
            t.addEventListener('click', function() {
                const item = t.closest('.menu-drop');
                const isOpen = item.classList.contains('open');
                document.querySelectorAll('.menu-drop.open').forEach(m => m.classList.remove('open'));
                if (!isOpen) item.classList.add('open');
            });
        });

        const darkToggle = document.getElementById('darkToggle');
        const iconSun = document.getElementById('iconSun');
        const iconMoon = document.getElementById('iconMoon');
        const html = document.documentElement;

        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            if (theme === 'dark') { iconSun.style.display = 'block'; iconMoon.style.display = 'none'; }
            else { iconSun.style.display = 'none'; iconMoon.style.display = 'block'; }
        }

        const saved = localStorage.getItem('theme') || 'light';
        applyTheme(saved);

        darkToggle.addEventListener('click', function() {
            const current = html.getAttribute('data-theme');
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    </script>
    @stack('scripts')
</body>
</html>
