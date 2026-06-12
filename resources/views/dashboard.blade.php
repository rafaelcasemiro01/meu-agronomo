<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Meu Agrônomo')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Notificações (sino da topbar) */
        .ma-notify { position: relative; }
        .ma-bell { position: relative; }
        .ma-bell__count { position: absolute; top: 3px; right: 3px; min-width: 16px; height: 16px; padding: 0 4px;
            display: grid; place-items: center; border-radius: 999px; background: var(--primary); color: var(--primary-ink, #fff);
            font-size: 10px; font-weight: 800; line-height: 1; box-shadow: 0 0 0 2px var(--surface); }
        [data-theme="dark"] .ma-bell__count { background: var(--sage-bright); color: #0f1311; }
        .ma-notify__panel { position: absolute; top: calc(100% + 10px); right: 0; width: 340px; max-width: 86vw; z-index: 80;
            background: var(--surface); border: 1px solid var(--border-soft); border-radius: 16px;
            box-shadow: 0 12px 40px -10px rgba(20,30,25,.28); overflow: hidden; animation: maNotifyIn .16s ease; }
        [data-theme="dark"] .ma-notify__panel { box-shadow: 0 14px 44px -12px rgba(0,0,0,.5); }
        @keyframes maNotifyIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: none; } }
        .ma-notify__head { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px;
            border-bottom: 1px solid var(--border-soft); font-size: 14px; font-weight: 700; letter-spacing: -.01em; }
        .ma-notify__badge { min-width: 20px; height: 20px; padding: 0 6px; display: grid; place-items: center;
            border-radius: 999px; background: var(--accent-soft); color: var(--primary); font-size: 11.5px; font-weight: 700; }
        [data-theme="dark"] .ma-notify__badge { color: var(--sage-bright); }
        .ma-notify__list { max-height: 320px; overflow-y: auto; }
        .ma-notify__item { display: flex; align-items: center; gap: 12px; padding: 13px 16px; text-decoration: none;
            color: inherit; border-bottom: 1px solid var(--border-soft); transition: background .14s; position: relative; }
        .ma-notify__item:last-child { border-bottom: 0; }
        .ma-notify__item:hover { background: var(--surface-2); }
        .ma-notify__ic { display: grid; place-items: center; width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
            background: var(--accent-soft); color: var(--primary); }
        [data-theme="dark"] .ma-notify__ic { color: var(--sage-bright); }
        .ma-notify__item.is-urgent .ma-notify__ic { background: color-mix(in srgb, var(--warn, #b07c2e) 16%, transparent); color: var(--warn, #b07c2e); }
        .ma-notify__ic svg { width: 18px; height: 18px; }
        .ma-notify__body { display: flex; flex-direction: column; min-width: 0; flex: 1; }
        .ma-notify__title { font-size: 13.5px; font-weight: 600; letter-spacing: -.01em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ma-notify__when { font-size: 12.5px; color: var(--text-mute); margin-top: 2px; }
        .ma-notify__item.is-urgent .ma-notify__when { color: var(--warn, #b07c2e); font-weight: 600; }
        .ma-notify__pulse { width: 8px; height: 8px; border-radius: 50%; background: var(--warn, #b07c2e); flex-shrink: 0; }
        .ma-notify__empty { display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 34px 20px; text-align: center;
            color: var(--text-mute); font-size: 13px; }
        .ma-notify__empty svg { width: 26px; height: 26px; opacity: .5; }
        .ma-notify__foot { display: block; padding: 12px 16px; text-align: center; font-size: 13px; font-weight: 600;
            color: var(--primary); text-decoration: none; border-top: 1px solid var(--border-soft); }
        [data-theme="dark"] .ma-notify__foot { color: var(--sage-bright); }
        .ma-notify__foot:hover { background: var(--surface-2); }
    </style>
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
                        <svg width="20" height="20" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 50V37" stroke="white" stroke-width="4.3" stroke-linecap="round"/>
                            <g transform="translate(32,38)">
                                <path transform="rotate(27)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
                                <path transform="rotate(-29) scale(0.9)" d="M0 0C-8.5-11-7-26 0-35 7-26 8.5-11 0 0Z" fill="white"/>
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
                   class="ma-nav__link {{ Request::routeIs('clientes.index') || Request::routeIs('clientes.edit') || Request::routeIs('clientes.show') ? 'active' : '' }}">
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
                <a href="{{ route('relatorios.index') }}"
                   class="ma-nav__link indent {{ Request::routeIs('relatorios.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M6 3.5h8l4 4V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1Z"/><path d="M13.5 3.5V8h4"/><path d="M8.5 13h7M8.5 16.5h5"/></svg>
                    Relatórios
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
                    <h1 class="ma-topbar__title">@yield('topbar-title', 'Início')</h1>
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
                    <form class="ma-topbar__search" action="{{ route('clientes.index') }}" method="GET" role="search">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Buscar clientes, visitas…">
                    </form>
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
                    <div class="ma-notify">
                        <button class="ma-theme-btn ma-bell" type="button" id="maBellBtn" aria-label="Notificações" aria-expanded="false">
                            <svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            @if(isset($notificacoes) && $notificacoes->count() > 0)
                                <span class="ma-bell__count">{{ $notificacoes->count() > 9 ? '9+' : $notificacoes->count() }}</span>
                            @endif
                        </button>
                        <div class="ma-notify__panel" id="maNotifyPanel" hidden>
                            <div class="ma-notify__head">
                                <span>Notificações</span>
                                @if(isset($notificacoes) && $notificacoes->count() > 0)
                                    <span class="ma-notify__badge">{{ $notificacoes->count() }}</span>
                                @endif
                            </div>
                            <div class="ma-notify__list">
                                @forelse(($notificacoes ?? []) as $n)
                                    <a href="{{ route('visitas.minhas') }}" class="ma-notify__item {{ $n->urgente ? 'is-urgent' : '' }}">
                                        <span class="ma-notify__ic">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </span>
                                        <span class="ma-notify__body">
                                            <span class="ma-notify__title">Visita — {{ $n->cliente }}</span>
                                            <span class="ma-notify__when">{{ $n->texto }}</span>
                                        </span>
                                        @if($n->urgente)<span class="ma-notify__pulse"></span>@endif
                                    </a>
                                @empty
                                    <div class="ma-notify__empty">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                        <span>Tudo em dia — nenhuma visita próxima.</span>
                                    </div>
                                @endforelse
                            </div>
                            @if(isset($notificacoes) && $notificacoes->count() > 0)
                                <a href="{{ route('visitas.minhas') }}" class="ma-notify__foot">Ver todas as visitas</a>
                            @endif
                        </div>
                    </div>
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
        const sidebar  = document.getElementById('maSidebar');
        const scrim    = document.getElementById('maScrim');
        const menuBtn  = document.getElementById('maMenuBtn');
        const closeBtn = document.getElementById('maSidebarClose');

        function openSidebar()  { sidebar.classList.add('open'); scrim.classList.add('visible'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.remove('open'); scrim.classList.remove('visible'); document.body.style.overflow = ''; }

        menuBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        scrim.addEventListener('click', closeSidebar);

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

        // --- Notificações (abrir/fechar o painel do sino) ---
        const bellBtn = document.getElementById('maBellBtn');
        const notifyPanel = document.getElementById('maNotifyPanel');
        if (bellBtn && notifyPanel) {
            bellBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const open = !notifyPanel.hasAttribute('hidden');
                if (open) {
                    notifyPanel.setAttribute('hidden', '');
                    bellBtn.setAttribute('aria-expanded', 'false');
                } else {
                    notifyPanel.removeAttribute('hidden');
                    bellBtn.setAttribute('aria-expanded', 'true');
                }
            });
            document.addEventListener('click', function(e) {
                if (!notifyPanel.hasAttribute('hidden') && !notifyPanel.contains(e.target) && !bellBtn.contains(e.target)) {
                    notifyPanel.setAttribute('hidden', '');
                    bellBtn.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') { notifyPanel.setAttribute('hidden', ''); bellBtn.setAttribute('aria-expanded', 'false'); }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
