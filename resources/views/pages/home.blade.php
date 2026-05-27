@extends('layouts.app')

@section('title', 'Home - ' . config('app.name', '[NOM_DU_SITE]'))
@section('nav_mode', 'dark')

@section('content')
    @php
        $mainOffers = [
            ['Comptes monetises', 'TikTok, Facebook et YouTube deja prets pour generer des revenus avec transfert accompagne.', route('service'), 'Voir les services', 'TT'],
            ['Comptes de demarrage', 'TikTok 10K, TikTok 25K, TikTok 50K et chaines YouTube avec audience mais non monetises.', route('service'), 'Decouvrir', 'YT'],
            ['Formation Crypto', 'Maitrisez le trading, les signaux et la gestion de portefeuille avec nos experts.', route('training'), 'Se former', 'BTC'],
            ['Formations digitales', 'Apprenez la monetisation, la croissance, les ventes digitales et l acquisition d audience.', route('training'), 'En savoir plus', 'f'],
        ];

        $popularProducts = [
            ['Compte TikTok monetise', 'TT', '245K abonnes', 'Monetise', 'A partir de 270 000 FCFA', '/assets/training/tiktok.jpg'],
            ['Page Facebook monetisee', 'f', '80K abonnes', 'Reels actif', 'A partir de 210 000 FCFA', '/assets/training/facebook-ads.jpg'],
            ['Chaine YouTube monetisee', 'YT', '12K abonnes', 'AdSense actif', 'A partir de 390 000 FCFA', '/assets/training/youtube-growth.jpg'],
            ['TikTok 10K non monetise', 'TT', '10K abonnes', 'Non monetise', 'A partir de 72 000 FCFA', '/assets/training/tiktok-blueprint.jpg'],
            ['YouTube 1K non monetise', 'YT', '1K abonnes', 'Non monetise', 'A partir de 108 000 FCFA', '/assets/training/youtube-growth.jpg'],
            ['Page Facebook verified', 'f', '45K abonnes', 'Badge actif', 'A partir de 174 000 FCFA', '/assets/training/facebook-ads.jpg'],
        ];

        $courses = [
            ['Masterclass Trading Crypto', 'Crypto', 'Signaux, entrees, sorties, gestion des risques et structure de marche.', '299 000 FCFA', '/assets/training/crypto-masterclass.jpg'],
            ['TikTok Monetisation Blueprint', 'Social', 'Creez des moteurs de contenu court et transformez l attention en revenus.', '209 000 FCFA', '/assets/training/tiktok-blueprint.jpg'],
            ['Croissance Chaine YouTube', 'Video', 'Recherche de niche, retention, miniatures, SEO et operations monetisees.', '179 000 FCFA', '/assets/training/youtube-growth.jpg'],
            ['Maitrise Facebook Ads', 'Ads', 'Structures de campagne pour comptes, formations et produits digitaux.', '209 000 FCFA', '/assets/training/facebook-ads.jpg'],
        ];

        $brandIcon = fn (string $icon): string => match ($icon) {
            'TT' => 'tiktok',
            'YT' => 'youtube',
            'f' => 'facebook',
            'IG' => 'instagram',
            'BTC' => 'bitcoin',
            default => 'briefcase',
        };
    @endphp

    {{-- Accueil connecte: version mobile-first inspiree du frontend Next.js. --}}
    <section class="relative -mt-24 overflow-hidden px-3 pb-10 pt-28 min-[380px]:px-4 sm:px-6 sm:pb-14 sm:pt-36 lg:px-8 lg:pb-10 xl:pb-12">
        <div class="absolute inset-0 overflow-hidden bg-navy"></div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-[minmax(0,0.8fr)_minmax(180px,58vw)] items-center gap-x-2 gap-y-5 min-[390px]:grid-cols-[minmax(0,0.78fr)_minmax(210px,58vw)] sm:grid-cols-1 sm:items-center sm:gap-8 md:grid-cols-[1fr_0.9fr] md:gap-8 xl:grid-cols-[1.05fr_0.95fr] xl:gap-16">
            <div class="z-10 -mt-3 min-w-0 text-white sm:mt-0">
                <div class="mb-3 inline-flex max-w-full items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.10em] text-gold backdrop-blur-md min-[390px]:text-[9px] sm:mb-8 sm:px-4 sm:py-2 sm:text-xs sm:tracking-[0.15em]">
                    <span class="relative flex h-1.5 w-1.5 shrink-0 sm:h-2 sm:w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold opacity-75"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-gold sm:h-2 sm:w-2"></span>
                    </span>
                    <span class="truncate">Plateforme N1 Europe & Afrique</span>
                </div>

                <h1 class="max-w-4xl text-[1.12rem] font-black leading-[1.05] tracking-normal min-[390px]:text-[1.38rem] sm:text-5xl md:text-6xl xl:text-[84px]">
                    <span class="block whitespace-nowrap text-gold sm:inline">L'excellence</span>
                    <span class="block whitespace-nowrap sm:inline">du Business</span>
                    <br class="hidden sm:block">
                    <span class="block whitespace-nowrap bg-gradient-to-r from-white via-white to-gold bg-clip-text text-transparent">Digital</span>
                </h1>

                <p class="mt-3 hidden max-w-xl text-sm font-medium leading-7 text-white/65 sm:mt-8 sm:block sm:text-xl sm:leading-9">
                    Bonjour {{ auth()->user()->name }}. Acquerez des actifs digitaux certifies, suivez vos achats et accedez a vos formations.
                </p>
            </div>

            <figure class="relative w-full justify-self-end pb-7 sm:max-w-md sm:justify-self-center sm:pb-6 md:col-start-2 md:row-span-2 md:row-start-1 md:max-w-none lg:pb-0 xl:max-w-none">
                <img src="{{ asset('/assets/n.png') }}" alt="Interface digitale PPMC" class="relative z-10 w-[136%] max-w-none object-contain drop-shadow-2xl min-[390px]:w-[132%] sm:w-full sm:max-w-full lg:animate-float">
                <img src="{{ asset('/assets/n.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-0 top-[72%] w-[136%] max-w-none origin-top scale-y-[-1] object-contain opacity-25 blur-[1px] min-[390px]:w-[132%] sm:w-full sm:max-w-full lg:hidden" style="-webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,.45), transparent 70%); mask-image: linear-gradient(to bottom, rgba(0,0,0,.45), transparent 70%);">
            </figure>

            <div class="col-span-2 z-10 text-white sm:col-span-1 md:col-start-1 md:row-start-2">
                <p class="mb-4 max-w-xl text-sm font-medium leading-6 text-white/65 sm:hidden">
                    Bonjour {{ auth()->user()->name }}. Suivez vos achats et accedez a vos formations.
                </p>
                <div class="mt-4 grid grid-cols-3 gap-1.5 sm:mt-8 sm:flex sm:flex-row sm:items-center sm:gap-5 lg:mt-6">
                    <a href="{{ route('catalog') }}" class="rounded-lg bg-gold px-2 py-2 text-center text-[9px] font-black leading-none text-navy shadow-gold transition hover:scale-105 sm:rounded-full sm:px-9 sm:py-5 sm:text-sm sm:leading-normal">Catalogue</a>
                    <a href="{{ route('training') }}" class="rounded-lg border border-white/20 bg-white/5 px-2 py-2 text-center text-[9px] font-black leading-none text-white backdrop-blur-md transition hover:bg-white/10 sm:rounded-full sm:px-9 sm:py-5 sm:text-sm sm:leading-normal">Formations</a>
                    <a href="{{ route('client.dashboard') }}" class="rounded-lg border border-white/20 bg-white/5 px-2 py-2 text-center text-[9px] font-black leading-none text-white backdrop-blur-md transition hover:bg-white/10 sm:rounded-full sm:px-9 sm:py-5 sm:text-sm sm:leading-normal">Espace</a>
                </div>

                <div class="mt-7 grid max-w-xs grid-cols-4 gap-2 sm:mt-8 sm:flex sm:max-w-none sm:flex-wrap sm:items-center sm:gap-8 lg:mt-7">
                    @foreach(['TT', 'YT', 'f', 'IG'] as $logo)
                        <span class="grid h-10 w-full place-items-center sm:w-10"><x-social-logo :name="$brandIcon($logo)" class="h-7 w-7" /></span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-10 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-7 max-w-3xl sm:mb-10">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-royal sm:text-sm sm:tracking-[0.18em]">Nos offres principales</p>
                <h2 class="mt-3 text-2xl font-black leading-tight tracking-normal text-navy sm:text-5xl">Tout ce qu'il faut pour lancer un business digital plus vite.</h2>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                @foreach($mainOffers as [$title, $description, $href, $cta, $icon])
                    <a href="{{ $href }}" class="premium-card group rounded-[1.25rem] p-3 transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem] sm:p-7">
                        <div class="mb-4 flex items-start justify-between gap-2 sm:mb-6">
                            <span class="grid h-10 w-10 shrink-0 place-items-center sm:h-12 sm:w-12"><x-social-logo :name="$brandIcon($icon)" class="h-8 w-8 sm:h-9 sm:w-9" /></span>
                            <span class="rounded-full bg-gold/20 px-2 py-1 text-[9px] font-black text-[#805B08] sm:text-[10px]">Premium</span>
                        </div>
                        <h3 class="text-sm font-black leading-tight text-navy sm:text-2xl">{{ $title }}</h3>
                        <p class="mt-2 line-clamp-2 text-[11px] font-semibold leading-5 text-slate-500 sm:mt-3 sm:text-sm sm:leading-7">{{ $description }}</p>
                        <span class="mt-4 inline-flex rounded-full bg-royal px-3 py-2 text-[11px] font-black text-white shadow-glow sm:mt-5 sm:px-4 sm:text-xs">{{ $cta }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-10 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-7 flex flex-col justify-between gap-5 sm:mb-10 md:flex-row md:items-end">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-royal sm:text-sm sm:tracking-[0.18em]">Produits populaires</p>
                    <h2 class="mt-3 max-w-3xl text-2xl font-black leading-tight text-navy sm:text-5xl">Les comptes les plus demandes par nos clients.</h2>
                </div>
                <a href="{{ route('service') }}" class="w-fit rounded-full bg-navy px-5 py-3 text-xs font-black text-white shadow-premium sm:px-6 sm:py-4 sm:text-sm">Voir tous les services</a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($popularProducts as [$title, $icon, $audience, $status, $price, $image])
                    <article class="overflow-hidden rounded-[1.25rem] bg-white shadow-premium transition hover:-translate-y-2 sm:rounded-[2rem]">
                        <div class="relative flex min-h-[125px] items-center justify-center overflow-hidden sm:min-h-[200px]">
                            <img src="{{ asset($image) }}" class="absolute inset-0 h-full w-full object-cover" alt="{{ $title }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/70 via-transparent to-transparent"></div>
                            <span class="relative grid h-11 w-11 place-items-center drop-shadow-[0_8px_20px_rgba(0,0,0,0.45)] sm:h-14 sm:w-14"><x-social-logo :name="$brandIcon($icon)" class="h-8 w-8 sm:h-10 sm:w-10" /></span>
                        </div>

                        <div class="p-3 sm:p-5">
                            <h3 class="min-h-10 text-sm font-black leading-tight text-navy sm:text-lg">{{ $title }}</h3>
                            <div class="mt-3 grid gap-2 sm:mt-4">
                                <div class="rounded-2xl bg-mist p-2.5 sm:p-3">
                                    <p class="text-[9px] font-black uppercase tracking-[0.12em] text-slate-400 sm:text-[10px] sm:tracking-[0.14em]">Audience</p>
                                    <p class="mt-1 text-[11px] font-black text-navy sm:text-xs">{{ $audience }}</p>
                                </div>
                                <div class="rounded-2xl bg-mist p-2.5 sm:p-3">
                                    <p class="text-[9px] font-black uppercase tracking-[0.12em] text-slate-400 sm:text-[10px] sm:tracking-[0.14em]">Statut</p>
                                    <p class="mt-1 text-[11px] font-black text-royal sm:text-xs">{{ $status }}</p>
                                </div>
                            </div>
                            <div class="mt-3 flex flex-col gap-2 sm:mt-4 sm:flex-row sm:items-center sm:justify-between">
                                <span class="text-[11px] font-black leading-4 text-navy sm:text-xs">{{ $price }}</span>
                                <a href="{{ route('service') }}" class="rounded-full bg-royal px-4 py-2 text-center text-[11px] font-black text-white sm:text-xs">Voir</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-10 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-7 flex flex-col justify-between gap-5 sm:mb-10 md:flex-row md:items-end">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-royal sm:text-sm sm:tracking-[0.18em]">Formations</p>
                    <h2 class="mt-3 max-w-3xl text-2xl font-black leading-tight text-navy sm:text-5xl">Apprenez a exploiter vos comptes comme un vrai business.</h2>
                </div>
                <a href="{{ route('training') }}" class="w-fit rounded-full bg-navy px-5 py-3 text-xs font-black text-white shadow-premium sm:px-6 sm:py-4 sm:text-sm">Toutes les formations</a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                @foreach($courses as [$title, $category, $description, $price, $image])
                    <article class="premium-card overflow-hidden rounded-[1.25rem] transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]">
                        <div class="relative h-28 overflow-hidden sm:h-56">
                            <img src="{{ asset($image) }}" alt="{{ $title }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-transparent to-transparent"></div>
                            <span class="absolute bottom-3 left-3 rounded-full bg-gold px-3 py-1 text-[10px] font-black text-navy sm:bottom-5 sm:left-5 sm:text-xs">{{ $category }}</span>
                        </div>

                        <div class="p-3 sm:p-6">
                            <h3 class="text-sm font-black leading-tight text-navy sm:text-xl">{{ $title }}</h3>
                            <p class="mt-2 line-clamp-2 text-[11px] font-semibold leading-5 text-slate-500 sm:text-xs">{{ $description }}</p>
                            <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <span class="text-xs font-black text-navy sm:text-xl">{{ $price }}</span>
                                <a href="{{ route('training') }}" class="rounded-full bg-royal px-4 py-2 text-center text-[11px] font-black text-white shadow-glow sm:text-xs">Voir</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
