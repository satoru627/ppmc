<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - {{ config('app.name', 'PPMC') }}</title>
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
                    colors: { navy: '#071B3B', royal: '#2563EB', gold: '#F4C76A', mist: '#F5F7FA' },
                    boxShadow: { soft: '0 18px 45px rgba(23,32,51,.10)', premium: '0 18px 52px rgba(7,27,59,.10)', glow: '0 12px 32px rgba(37,99,235,.30)', gold: '0 14px 38px rgba(244,199,106,.34)' }
                }
            }
        }
    </script>
    <style>html,body{max-width:100%;overflow-x:hidden}main{min-width:0}img,svg,video,canvas{max-width:100%}.premium-card{border:1px solid rgba(230,235,243,.92);background:#fff;box-shadow:0 18px 52px rgba(7,27,59,.10)}.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.site-image-bg,.bg-navy{background-color:#000080!important;background-image:url('{{ asset('/assets/hero-background.jpg') }}')!important;background-size:cover!important;background-position:center!important}</style>
</head>
<body class="bg-mist font-sans text-navy antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[290px_1fr]">
        <aside class="sticky top-0 z-50 bg-navy px-3 py-3 text-white lg:static lg:min-h-screen lg:px-5 lg:py-6">
            <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-2 pr-20 lg:gap-3 lg:pr-0">
                <img src="{{ asset('/assets/logo.png') }}" alt="PPMC" class="h-10 w-auto max-w-[4.75rem] shrink-0 rounded-2xl object-contain shadow-gold lg:h-11 lg:max-w-[5.25rem]">
                <span class="truncate text-sm font-black lg:text-base">PPMC</span>
            </a>
            <nav class="mt-3 flex gap-2 overflow-x-auto pb-1 text-xs font-black lg:mt-10 lg:grid lg:gap-2 lg:overflow-visible lg:pb-0 lg:text-sm">
                @foreach([
                    [route('admin.dashboard'), 'Tableau de bord'],
                    [route('admin.products.index'), 'Produits'],
                    [route('admin.orders.index'), 'Commandes'],
                    [route('admin.support.index'), 'Support'],
                    [route('admin.users.index'), 'Utilisateurs'],
                    [route('admin.stats'), 'Statistiques'],
                    [route('home'), 'Retour site'],
                ] as [$href, $label])
                    <a class="shrink-0 rounded-full bg-white/5 px-3 py-2 text-white/70 transition hover:bg-white/10 hover:text-gold lg:rounded-2xl lg:bg-transparent lg:px-4 lg:py-3" href="{{ $href }}">{{ $label }}</a>
                @endforeach
            </nav>
            <form class="absolute right-3 top-3 lg:static lg:mt-10" action="{{ route('logout') }}" method="POST">@csrf<button class="rounded-full bg-white/10 px-3 py-2 text-xs font-black text-white hover:bg-royal lg:w-full lg:rounded-2xl lg:px-4 lg:py-3 lg:text-left lg:text-sm"><span class="lg:hidden">Sortir</span><span class="hidden lg:inline">Deconnexion</span></button></form>
        </aside>
        <section class="min-w-0">
            <header class="border-b border-slate-200 bg-white px-3 py-4 shadow-premium sm:px-8 sm:py-5">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0"><p class="text-[10px] font-black uppercase tracking-[0.16em] text-royal sm:text-xs sm:tracking-[0.18em]">Back-office premium</p><h1 class="mt-1 truncate text-xl font-black sm:text-2xl">@yield('page_title', 'Administration')</h1></div>
                    <p class="shrink-0 truncate text-xs font-bold text-slate-500 sm:text-sm">{{ auth()->user()->name }}</p>
                </div>
            </header>
            @if(session('success'))<div class="mx-4 mt-5 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-black text-emerald-700 sm:mx-8">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="mx-4 mt-5 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-black text-red-700 sm:mx-8">{{ $errors->first() }}</div>@endif
            <main class="px-3 py-4 sm:px-8 sm:py-6">@yield('content')</main>
        </section>
    </div>
</body>
</html>
