<!DOCTYPE html>
<html lang="pt-BR" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Calculadora de Rescisão Trabalhista')</title>
    <meta name="description" content="@yield('description', 'Descubra rapidamente quanto você tem a receber ou pagar em uma rescisão trabalhista com nossa calculadora online grátis.')">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#ffffff">
    <meta name="theme-color" media="(prefers-color-scheme: dark)"  content="#0f172a">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tema: sistema como padrão, localStorage sobrescreve, botão para alternar --}}
    <script>
        (function () {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isDark = saved ? saved === 'dark' : prefersDark;
            if (isDark) document.documentElement.classList.add('dark');
            else document.documentElement.classList.remove('dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>

<body class="flex flex-col min-h-screen
             bg-slate-50 text-slate-800
             dark:bg-slate-950 dark:text-slate-100
             transition-colors duration-300">

    <!-- ========================= HEADER ========================= -->
    <header class="sticky top-0 z-40
                   bg-white/90 dark:bg-slate-900/90
                   border-b border-slate-200 dark:border-slate-800
                   shadow-sm glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group" aria-label="Página inicial">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl
                             bg-brand-500 text-white shadow-md
                             group-hover:bg-brand-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </span>
                <span class="text-lg font-bold tracking-tight
                             bg-gradient-to-r from-brand-600 to-indigo-600
                             dark:from-brand-400 dark:to-indigo-400
                             bg-clip-text text-transparent">
                    Rescisão CLT
                </span>
            </a>

            <!-- Nav desktop -->
            <nav class="hidden md:flex items-center gap-1" aria-label="Navegação principal">
                <a href="/como-calcular-rescisao-trabalhista"
                   class="px-3 py-2 rounded-lg text-sm font-medium
                          text-slate-600 hover:text-brand-600 hover:bg-brand-50
                          dark:text-slate-300 dark:hover:text-brand-400 dark:hover:bg-brand-950/40
                          transition-all duration-150">
                    Como Funciona
                </a>
                <a href="/multa-fgts-40-por-cento"
                   class="px-3 py-2 rounded-lg text-sm font-medium
                          text-slate-600 hover:text-brand-600 hover:bg-brand-50
                          dark:text-slate-300 dark:hover:text-brand-400 dark:hover:bg-brand-950/40
                          transition-all duration-150">
                    Multa FGTS
                </a>
                <a href="/"
                   class="ml-2 px-4 py-2 rounded-lg text-sm font-semibold
                          bg-brand-500 hover:bg-brand-600 text-white
                          shadow-sm shadow-brand-500/30
                          transition-all duration-150">
                    Calculadora
                </a>

                <!-- Botão Toggle Tema -->
                <button id="theme-toggle"
                        type="button"
                        aria-label="Alternar tema claro/escuro"
                        title="Alternar tema"
                        class="ml-1 p-2 rounded-lg
                               text-slate-500 dark:text-slate-400
                               hover:bg-slate-100 dark:hover:bg-slate-800
                               transition-all duration-200">
                    <!-- Ícone Sol (light mode) -->
                    <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Ícone Lua (dark mode) -->
                    <svg id="icon-moon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
            </nav>

            <!-- Hamburguer mobile + toggle tema -->
            <div class="flex items-center gap-1 md:gap-0">

                <!-- Botão toggle tema (só mobile — desktop tem o próprio no nav) -->
                <button id="theme-toggle-mobile"
                        type="button"
                        aria-label="Alternar tema claro/escuro"
                        class="md:hidden p-2 rounded-lg
                               text-slate-500 dark:text-slate-400
                               hover:bg-slate-100 dark:hover:bg-slate-800
                               transition-all duration-200">
                    <svg id="icon-sun-m" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg id="icon-moon-m" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- Hamburguer (só mobile) -->
                <button id="nav-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu"
                        aria-label="Abrir menu"
                        class="md:hidden p-2 rounded-lg text-slate-500
                               hover:bg-slate-100 dark:hover:bg-slate-800
                               transition-colors duration-150">
                    <svg id="icon-menu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 dark:border-slate-800">
            <div class="px-4 py-3 space-y-1">
                <a href="/como-calcular-rescisao-trabalhista"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium
                          text-slate-700 hover:text-brand-600 hover:bg-brand-50
                          dark:text-slate-300 dark:hover:text-brand-400 dark:hover:bg-brand-950/40
                          transition-all duration-150">
                    Como Funciona
                </a>
                <a href="/multa-fgts-40-por-cento"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium
                          text-slate-700 hover:text-brand-600 hover:bg-brand-50
                          dark:text-slate-300 dark:hover:text-brand-400 dark:hover:bg-brand-950/40
                          transition-all duration-150">
                    Multa FGTS
                </a>
                <a href="/"
                   class="block px-3 py-2.5 rounded-lg text-sm font-semibold
                          bg-brand-500 text-white text-center mt-2
                          transition-colors duration-150">
                    Calculadora
                </a>
            </div>
        </div>
    </header>

    <!-- ========================= MAIN ========================= -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- ========================= FOOTER ========================= -->
    <footer class="mt-auto bg-white dark:bg-slate-900
                   border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

                <!-- Marca -->
                <div>
                    <a href="{{ url('/') }}" class="flex items-center gap-2 mb-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-brand-500 text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <span class="font-bold text-slate-800 dark:text-white">Rescisão CLT</span>
                    </a>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        Simulador gratuito para calcular rescisão trabalhista com base nas regras atuais da CLT.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-3">Páginas</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-sm text-slate-500 dark:text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Calculadora</a></li>
                        <li><a href="/como-calcular-rescisao-trabalhista" class="text-sm text-slate-500 dark:text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Como Funciona</a></li>
                        <li><a href="/multa-fgts-40-por-cento" class="text-sm text-slate-500 dark:text-slate-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Multa FGTS (40%)</a></li>
                    </ul>
                </div>

                <!-- Aviso -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-3">Aviso Legal</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        Esta é uma ferramenta de <strong class="font-medium text-slate-600 dark:text-slate-300">estimativa</strong> baseada nas regras gerais vigentes (CLT&nbsp;2026).
                        Não possui valor legal e não substitui o trabalho de um contador ou advogado trabalhista.
                    </p>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 dark:border-slate-800 text-center">
                <p class="text-xs text-slate-400 dark:text-slate-500">
                    &copy; {{ date('Y') }} Calculadora de Rescisão Trabalhista. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts de UI -->
    <script>
        (function () {
            /* ---- Toggle Tema ---- */
            function isDark() {
                return document.documentElement.classList.contains('dark');
            }

            function setTheme(dark) {
                if (dark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
                syncIcons();
            }

            function syncIcons() {
                var dark = isDark();
                /* Desktop */
                var sun  = document.getElementById('icon-sun');
                var moon = document.getElementById('icon-moon');
                /* Mobile */
                var sunM  = document.getElementById('icon-sun-m');
                var moonM = document.getElementById('icon-moon-m');

                if (sun)  sun.classList.toggle('hidden', !dark);
                if (moon) moon.classList.toggle('hidden', dark);
                if (sunM)  sunM.classList.toggle('hidden', !dark);
                if (moonM) moonM.classList.toggle('hidden', dark);
            }

            // Inicializa ícones conforme tema atual
            syncIcons();

            // Botão desktop
            var btn = document.getElementById('theme-toggle');
            if (btn) btn.addEventListener('click', function () { setTheme(!isDark()); });

            // Botão mobile
            var btnM = document.getElementById('theme-toggle-mobile');
            if (btnM) btnM.addEventListener('click', function () { setTheme(!isDark()); });

            /* ---- Menu Mobile ---- */
            var navBtn = document.getElementById('nav-toggle');
            var menu   = document.getElementById('mobile-menu');
            var iconM  = document.getElementById('icon-menu');
            var iconX  = document.getElementById('icon-close');
            if (navBtn) {
                navBtn.addEventListener('click', function () {
                    var isOpen = menu.classList.toggle('hidden') === false;
                    navBtn.setAttribute('aria-expanded', String(isOpen));
                    iconM.classList.toggle('hidden', isOpen);
                    iconX.classList.toggle('hidden', !isOpen);
                });
            }
        })();
    </script>

    @yield('scripts')
</body>
</html>
