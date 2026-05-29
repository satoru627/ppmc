<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'PPMC'))</title>
    <link rel="icon" type="image/png" href="{{ asset('/assets/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('/assets/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                screens: {
                    sm: '640px',
                    md: '768px',
                    lg: '1180px',
                    xl: '1280px',
                    '2xl': '1536px'
                },
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        navy: '#071B3B',
                        ink: '#071B3B',
                        royal: '#2563EB',
                        gold: '#F4C76A',
                        mist: '#F5F7FA',
                        primary: '#E8184A',
                        secondary: '#F5A623'
                    },
                    boxShadow: {
                        soft: '0 18px 45px rgba(23, 32, 51, 0.10)',
                        premium: '0 18px 52px rgba(7, 27, 59, 0.10)',
                        glow: '0 12px 32px rgba(37, 99, 235, 0.30)',
                        gold: '0 14px 38px rgba(244, 199, 106, 0.34)'
                    },
                    backgroundImage: {
                        'navy-radial': 'radial-gradient(circle at top left, #123A75, #071B3B 48%, #041126)',
                    }
                }
            }
        }
    </script>
    <style>
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        html, body { max-width: 100%; overflow-x: hidden; }
        body { margin: 0; min-height: 100vh; color: #071B3B; background: #fff; letter-spacing: 0; }
        main { min-width: 0; }
        img, svg, video, canvas { max-width: 100%; }
        .premium-card { border: 1px solid rgba(230,235,243,.92); background: #fff; box-shadow: 0 18px 52px rgba(7,27,59,.10); }
        .glass-panel { border: 1px solid rgba(255,255,255,.18); background: rgba(255,255,255,.10); box-shadow: 0 24px 80px rgba(0,0,0,.22); backdrop-filter: blur(22px); }
        .noise-overlay::after { content: ""; position: absolute; inset: 0; pointer-events: none; background: linear-gradient(120deg, transparent, rgba(255,255,255,.08), transparent 46%), radial-gradient(circle at 14% 18%, rgba(255,255,255,.12), transparent 18%); }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-20px); } }
        @keyframes float-slow { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-14px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 9s ease-in-out infinite; }
        .perspective-1000 { perspective: 1000px; }
        .brand-icon { display: grid; place-items: center; color: white; font-weight: 950; line-height: 1; }
        .hamburger-line { display: block; height: 2px; width: 18px; border-radius: 999px; background: currentColor; transition: transform .26s ease, opacity .2s ease; }
        .nav-toggle[aria-expanded="true"] .hamburger-line:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        .nav-toggle[aria-expanded="true"] .hamburger-line:nth-child(2) { opacity: 0; }
        .nav-toggle[aria-expanded="true"] .hamburger-line:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }
        .mobile-menu-root { opacity: 0; pointer-events: none; transition: opacity .25s ease; }
        .mobile-menu-root.is-open { opacity: 1; pointer-events: auto; }
        .mobile-menu-panel { opacity: 0; transform: translateX(24px) scale(.98); transition: opacity .28s ease, transform .28s ease; }
        .mobile-menu-root.is-open .mobile-menu-panel { opacity: 1; transform: translateX(0) scale(1); }
        @keyframes loading-spin { to { transform: rotate(360deg); } }
        .loading-spinner {
            display: none;
            height: 1rem;
            width: 1rem;
            flex: 0 0 auto;
            margin-left: .55rem;
            vertical-align: -.15rem;
            border-radius: 999px;
            border: 2px solid currentColor;
            border-right-color: transparent;
            animation: loading-spin .65s linear infinite;
        }
        .is-loading {
            cursor: wait;
            pointer-events: none;
        }
        .is-loading .loading-spinner {
            display: inline-block;
        }
        .site-image-bg,
        .bg-navy,
        .bg-navy\/40,
        .bg-navy\/55,
        .bg-navy\/90,
        .bg-navy-radial {
            background-color: #000080 !important;
            background-image: url('{{ asset('/assets/hero-background.jpg') }}') !important;
            background-size: cover !important;
            background-position: center !important;
        }
    </style>
    @stack('head')
</head>
<body class="flex min-h-screen flex-col font-sans antialiased">
    @php
        $darkNav = trim($__env->yieldContent('nav_mode')) === 'dark';
        $hideLayoutShell = trim($__env->yieldContent('hide_layout_shell')) === 'true';
        $navText = $darkNav ? 'text-white/75 hover:text-gold' : 'text-slate-600 hover:text-royal';
        $navShell = $darkNav
            ? 'border-white/15 bg-white/[0.10] text-white shadow-[0_24px_80px_rgba(0,0,0,0.24)]'
            : 'border-white/70 bg-white/70 text-navy shadow-premium';
    @endphp

    @unless($hideLayoutShell)
    <header class="fixed inset-x-0 top-0 z-50 px-3 pt-3 sm:px-6 sm:pt-4 lg:px-8">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-3 rounded-[1.25rem] border px-3 backdrop-blur-2xl transition-all duration-300 sm:h-20 sm:rounded-[1.75rem] sm:px-5 {{ $navShell }}">
            <a href="{{ auth()->check() ? route('client.home') : route('home') }}" class="flex min-w-0 items-center gap-2 sm:gap-3">
                <img src="{{ asset('/assets/logo.png') }}" alt="PPMC" class="h-10 w-auto max-w-[4.75rem] shrink-0 rounded-xl object-contain shadow-premium sm:h-11 sm:max-w-[5.25rem]">
                <span class="truncate text-xl font-black tracking-normal {{ $darkNav ? 'text-white' : 'text-navy' }}">PPMC</span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a href="{{ route('home') }}" class="text-sm font-extrabold transition {{ $navText }}">Accueil</a>
                <a href="{{ route('catalog') }}" class="text-sm font-extrabold transition {{ $navText }}">Catalogue</a>
                <a href="{{ route('training') }}" class="text-sm font-extrabold transition {{ $navText }}">Formations</a>
                <a href="{{ route('service') }}" class="text-sm font-extrabold transition {{ $navText }}">Services</a>
                <a href="{{ route('about') }}" class="text-sm font-extrabold transition {{ $navText }}">A propos</a>
                @auth
                    <a href="{{ route('contact') }}" class="text-sm font-extrabold transition {{ $navText }}">Contact</a>
                @endauth
            </nav>

            <div class="hidden items-center gap-4 lg:flex">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-black transition hover:text-gold {{ $darkNav ? 'text-white' : 'text-navy' }}" data-loading-link>Se connecter</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#D9A233] px-5 py-3 text-sm font-black text-white shadow-[0_12px_30px_rgba(217,162,51,.35)] transition hover:-translate-y-0.5 active:translate-y-0" data-loading-link>S'enregistrer</a>
                @else
                    <a href="{{ route('client.home') }}" class="text-sm font-black transition hover:text-gold {{ $darkNav ? 'text-white' : 'text-navy' }}">Home</a>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}" class="rounded-xl bg-[#D9A233] px-5 py-3 text-sm font-black text-white shadow-[0_12px_30px_rgba(217,162,51,.35)] transition hover:-translate-y-0.5 active:translate-y-0">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-sm font-black transition hover:text-gold {{ $darkNav ? 'text-white/75' : 'text-slate-500' }}">Sortir</button>
                    </form>
                @endguest
            </div>

            <button
                type="button"
                class="nav-toggle grid h-11 w-11 shrink-0 place-items-center rounded-2xl border transition hover:scale-105 active:scale-95 lg:hidden {{ $darkNav ? 'border-white/15 bg-white/10 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.18)]' : 'border-white/70 bg-white/70 text-navy shadow-premium' }}"
                aria-label="Ouvrir le menu"
                aria-controls="mobile-menu"
                aria-expanded="false"
                data-nav-toggle
            >
                <span class="grid gap-1">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </span>
            </button>
        </div>
    </header>

    <div id="mobile-menu" class="mobile-menu-root fixed inset-0 z-[60] lg:hidden" aria-hidden="true" data-mobile-menu>
        <button type="button" class="absolute inset-0 bg-black/45 backdrop-blur-sm" aria-label="Fermer le menu" data-nav-close></button>
        <aside class="mobile-menu-panel absolute right-3 top-24 w-[min(340px,calc(100vw-24px))] rounded-[2rem] border border-white/20 bg-white/[0.12] p-5 text-white shadow-[0_24px_80px_rgba(0,0,0,0.35)] backdrop-blur-2xl sm:right-4 sm:top-28 sm:w-[min(360px,calc(100vw-32px))] sm:p-6">
            <a href="{{ route('home') }}" class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>Accueil</a>
            <a href="{{ route('catalog') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>Catalogue</a>
            <a href="{{ route('training') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>Formations</a>
            <a href="{{ route('service') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>Services</a>
            <a href="{{ route('about') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>A propos</a>
            <a href="{{ route('home') }}#avis" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>Avis</a>
            <a href="{{ route('home') }}#faq" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>FAQ</a>

            @auth
                <a href="{{ route('contact') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-nav-link>Contact</a>
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.home') }}" class="mt-4 block rounded-full bg-[#D9A233] px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white shadow-gold" data-nav-link>Mon espace</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full rounded-full border border-white/20 px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white">Deconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mt-4 block rounded-full border border-white/20 px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white" data-nav-link data-loading-link>Connexion</a>
                <a href="{{ route('register') }}" class="mt-2 block rounded-full bg-[#D9A233] px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white shadow-gold" data-nav-link data-loading-link>Inscription</a>
            @endauth
        </aside>
    </div>
    <div class="h-20 sm:h-24" aria-hidden="true"></div>
    @endunless

    @if(session('success'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-black text-emerald-700">{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-black text-red-700">{{ $errors->first() }}</div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    @unless($hideLayoutShell)
    <footer class="site-image-bg px-4 py-10 text-white sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-8">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('/assets/logo.png') }}" alt="PPMC" class="h-11 w-auto max-w-[5.25rem] rounded-2xl object-contain">
                    <div>
                        <p class="text-lg font-black">PPMC</p>
                        <p class="mt-1 text-xs font-semibold text-white/55">au coeur numerique au service de la vision</p>
                    </div>
                </div>

                <nav class="flex flex-wrap gap-x-5 gap-y-2 text-sm font-bold text-white/65">
                    <a href="{{ route('catalog') }}" class="transition hover:text-gold">Catalogue</a>
                    <a href="{{ route('training') }}" class="transition hover:text-gold">Formations</a>
                    <a href="{{ route('service') }}" class="transition hover:text-gold">Services</a>
                    <a href="{{ route('about') }}" class="transition hover:text-gold">A propos</a>
                    @auth
                        <a href="{{ route('contact') }}" class="transition hover:text-gold">Contact</a>
                    @endauth
                </nav>
            </div>

            <div class="flex flex-col justify-between gap-3 border-t border-white/10 pt-6 text-xs font-semibold text-white/45 md:flex-row">
                    <p>{{ now()->year }} PPMC. Tous droits reserves.</p>
                
            </div>
        </div>
    </footer>
    @endunless
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const setLoading = (element) => {
                if (!element || element.classList.contains('is-loading')) return;

                element.classList.add('is-loading');
                element.setAttribute('aria-busy', 'true');

                if (!element.querySelector('.loading-spinner')) {
                    const spinner = document.createElement('span');
                    spinner.className = 'loading-spinner';
                    spinner.setAttribute('aria-hidden', 'true');
                    element.appendChild(spinner);
                }
            };

            document.querySelectorAll('[data-loading-link]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    const href = link.getAttribute('href') || '';
                    const target = link.getAttribute('target');

                    if (event.defaultPrevented || target === '_blank' || href.startsWith('#')) return;

                    setLoading(link);
                });
            });

            document.querySelectorAll('[data-loading-form]').forEach((form) => {
                form.addEventListener('submit', () => {
                    const button = form.querySelector('[data-loading-submit]');
                    setLoading(button);
                    if (button) button.setAttribute('disabled', 'disabled');
                });
            });

            document.querySelectorAll('[data-password-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(button.dataset.passwordTarget);
                    if (!input) return;

                    const showPassword = input.type === 'password';
                    input.type = showPassword ? 'text' : 'password';
                    button.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
                    button.setAttribute('aria-label', showPassword
                        ? (button.dataset.passwordLabelHide || 'Masquer le mot de passe')
                        : (button.dataset.passwordLabelShow || 'Afficher le mot de passe'));
                    button.querySelector('[data-password-icon-show]')?.classList.toggle('hidden', showPassword);
                    button.querySelector('[data-password-icon-hide]')?.classList.toggle('hidden', !showPassword);
                });
            });

            const toggle = document.querySelector('[data-nav-toggle]');
            const menu = document.querySelector('[data-mobile-menu]');
            if (!toggle || !menu) return;

            const setOpen = (open) => {
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
                menu.classList.toggle('is-open', open);
                menu.setAttribute('aria-hidden', open ? 'false' : 'true');
                document.body.style.overflow = open ? 'hidden' : '';
            };

            toggle.addEventListener('click', () => {
                setOpen(toggle.getAttribute('aria-expanded') !== 'true');
            });

            menu.querySelectorAll('[data-nav-close], [data-nav-link]').forEach((element) => {
                element.addEventListener('click', () => setOpen(false));
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') setOpen(false);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
