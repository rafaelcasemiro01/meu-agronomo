<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Meu Agrônomo')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const t = localStorage.getItem('ma_theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body class="dashboard-body">

    {{-- Scrim (overlay mobile) --}}
    <div class="ma-scrim" id="maScrim"></div>

    <div class="ma-shell">

        {{-- SIDEBAR --}}
        <aside class="ma-sidebar" id="maSidebar">

            <div class="ma-sidebar__brand">
                <div class="sidebar-brand">
                    <div class="sidebar-brand-icon">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 50V37" stroke="currentColor" stroke-width="4.3" stroke-linecap="round"/>
                            <g transform="translate(32,38)">
                                <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="currentColor"/>
                                <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="currentColor"/>
                            </g>
                        </svg>
                    </div>
                    <div>
                        <div class="sidebar-brand-name">Meu Agrônomo</div>
                        <div class="sidebar-brand-sub">Gestão agrícola</div>
                    </div>
                </div>
                <button class="ma-iconbtn" id="maSidebarClose" aria-label="Fechar menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <nav class="ma-nav">
                <a href="{{ route('dashboard') }}"
                   class="ma-nav__link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Início
                </a>

                <div class="t-eyebrow" style="padding: 14px 8px 5px;">Gestão</div>

                <a href="{{ route('clientes.index') }}"
                   class="ma-nav__link {{ Request::routeIs('clientes.index') || Request::routeIs('clientes.edit') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Clientes
                </a>
                <a href="{{ route('clientes.create') }}"
                   class="ma-nav__link indent {{ Request::routeIs('clientes.create') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Adicionar cliente
                </a>

                <div class="t-eyebrow" style="padding: 14px 8px 5px;">Visita técnica</div>

                <a href="{{ route('visitas.agendar') }}"
                   class="ma-nav__link {{ Request::routeIs('visitas.agendar') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="12" y1="14" x2="12" y2="14" stroke-width="3"/></svg>
                    Agendar visita
                </a>
                <a href="{{ route('visitas.minhas') }}"
                   class="ma-nav__link indent {{ Request::routeIs('visitas.minhas') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Minhas visitas
                </a>

                <div class="t-eyebrow" style="padding: 14px 8px 5px;">Conta</div>

                <a href="{{ route('perfil.info') }}"
                   class="ma-nav__link {{ Request::routeIs('perfil.info') || Request::routeIs('perfil.senha') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Meu perfil
                </a>
            </nav>

            <div class="ma-sidebar__foot">
                <div class="ma-sidebar__user">
                    <div class="ma-sidebar__avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div style="overflow:hidden; flex:1;">
                        <div class="ma-sidebar__uname">{{ Auth::user()->name }}</div>
                        <div class="ma-sidebar__uemail">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="ma-sidebar__logout">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Sair da conta
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            </div>

        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="ma-main">

            {{-- TOPBAR --}}
            <header class="ma-topbar">
                <div class="ma-topbar__left">
                    <button class="ma-menu-btn" id="maMenuBtn" aria-label="Abrir menu">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                    <div class="ma-topbar__brand">
                        <div class="brand-icon">
                            <svg width="14" height="14" viewBox="0 0 64 64" fill="none">
                                <path d="M32 50V37" stroke="white" stroke-width="5.5" stroke-linecap="round"/>
                                <g transform="translate(32,38)">
                                    <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                                    <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                                </g>
                            </svg>
                        </div>
                        Meu Agrônomo
                    </div>
                </div>
                <div class="ma-topbar__right">
                    <button class="ma-theme-btn" id="maThemeBtn" aria-label="Alternar tema">
                        <svg id="iconSun" viewBox="0 0 24 24" style="display:none">
                            <circle cx="12" cy="12" r="5"/>
                            <line x1="12" y1="1" x2="12" y2="3"/>
                            <line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/>
                            <line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                        <svg id="iconMoon" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                        </svg>
                    </button>
                    <div class="ma-user-avatar" title="{{ Auth::user()->name }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>

            {{-- CONTEÚDO DA PÁGINA --}}
            <div class="ma-content">
                @yield('main-content')
            </div>

        </main>

    </div>{{-- /.ma-shell --}}

    <script defer>
        // --- Sidebar (mobile) ---
        const sidebar  = document.getElementById('maSidebar');
        const scrim    = document.getElementById('maScrim');
        const menuBtn  = document.getElementById('maMenuBtn');
        const closeBtn = document.getElementById('maSidebarClose');

        function openSidebar()  { sidebar.classList.add('open'); scrim.classList.add('visible'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.remove('open'); scrim.classList.remove('visible'); document.body.style.overflow = ''; }

        menuBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        scrim.addEventListener('click', closeSidebar);

        // --- Dark mode ---
        const themeBtn  = document.getElementById('maThemeBtn');
        const iconSun   = document.getElementById('iconSun');
        const iconMoon  = document.getElementById('iconMoon');
        const htmlEl    = document.documentElement;

        function applyTheme(theme) {
            htmlEl.setAttribute('data-theme', theme);
            localStorage.setItem('ma_theme', theme);
            iconSun.style.display  = theme === 'dark' ? 'block' : 'none';
            iconMoon.style.display = theme === 'dark' ? 'none'  : 'block';
        }

        applyTheme(localStorage.getItem('ma_theme') || 'light');

        themeBtn.addEventListener('click', function() {
            applyTheme(htmlEl.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });
    </script>
    @stack('scripts')
</body>
</html>
