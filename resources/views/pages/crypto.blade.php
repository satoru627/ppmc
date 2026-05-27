@extends('layouts.app')

@section('title', 'Services - ' . config('app.name', '[NOM_DU_SITE]'))
@section('nav_mode', 'dark')

@section('content')
    @php
        $platforms = $platforms ?? [
            'tiktok' => ['name' => 'TikTok', 'logo' => 'tiktok', 'headline' => 'Comptes TikTok', 'description' => 'Comptes TikTok monetises ou de demarrage.', 'fallback_count' => '50+', 'metric' => 'Videos courtes'],
            'facebook' => ['name' => 'Facebook', 'logo' => 'facebook', 'headline' => 'Pages Facebook', 'description' => 'Pages Facebook monetisees et actives.', 'fallback_count' => '20+', 'metric' => 'Reels & audience'],
            'youtube' => ['name' => 'YouTube', 'logo' => 'youtube', 'headline' => 'Chaines YouTube', 'description' => 'Chaines YouTube monetisees ou starter.', 'fallback_count' => '30+', 'metric' => 'AdSense & contenu'],
        ];
        $selectedPlatform = $selectedPlatform ?? null;
        $currentPlatform = $selectedPlatform ? $platforms[$selectedPlatform] : null;

        $fallbackProducts = [
            'tiktok' => [
                ['Compte TikTok monetise', 'tiktok', 'Audience active, historique propre et transfert accompagne.', '50K - 250K', 'Monetise', 'A partir de 270 000 FCFA', '/assets/training/tiktok.jpg', $products->firstWhere('slug', 'compte-tiktok-monetise')],
                ['Compte TikTok 10K', 'tiktok', 'Compte TikTok avec 10 000 abonnes, parfait pour lancer une niche.', '10K abonnes', 'Non monetise', '72 000 FCFA', '/assets/training/tiktok-blueprint.jpg', $products->firstWhere('slug', 'compte-tiktok-10k')],
                ['Compte TikTok 25K', 'tiktok', 'Base solide pour contenus lifestyle, business ou divertissement.', '25K abonnes', 'Starter', '132 000 FCFA', '/assets/training/tiktok.jpg', $products->firstWhere('slug', 'compte-tiktok-25k')],
            ],
            'facebook' => [
                ['Page Facebook monetisee', 'facebook', 'Page eligible a la monetisation, ideale pour reels et revenus publicitaires.', '20K - 180K', 'Monetisee', 'A partir de 210 000 FCFA', '/assets/training/facebook-ads.jpg', $products->firstWhere('slug', 'page-facebook-monetisee')],
                ['Page Facebook verified', 'facebook', 'Page avec audience de niche et badge actif selon disponibilite.', '45K abonnes', 'Premium', 'A partir de 174 000 FCFA', '/assets/training/facebook-ads.jpg', $products->firstWhere('slug', 'page-facebook-verified')],
                ['Page Facebook Reels', 'facebook', 'Page orientee contenu court avec potentiel publicitaire.', '80K abonnes', 'Reels actif', 'A partir de 210 000 FCFA', '/assets/training/digital-products.jpg', null],
            ],
            'youtube' => [
                ['Chaine YouTube monetisee', 'youtube', 'Programme partenaire actif, abonnes reels et base prete pour publication.', '1K - 100K', 'Monetisee', 'A partir de 390 000 FCFA', '/assets/training/youtube-growth.jpg', $products->firstWhere('slug', 'chaine-youtube-monetisee')],
                ['Chaine YouTube 1K', 'youtube', 'Chaine avec 1 000 abonnes, non monetisee, parfaite pour demarrer vite.', '1K abonnes', 'Non monetisee', '108 000 FCFA', '/assets/training/academy-dashboard.jpg', $products->firstWhere('slug', 'chaine-youtube-1k')],
                ['YouTube Channel 5K Growth', 'youtube', 'Base solide pour publication reguliere et croissance organique.', '5K abonnes', 'Starter', '210 000 FCFA', '/assets/training/youtube-growth.jpg', $products->firstWhere('slug', 'youtube-channel-5k-growth')],
            ],
        ];
    @endphp

    <section class="relative -mt-24 overflow-hidden px-4 pb-10 pt-28 sm:px-6 sm:pb-20 sm:pt-36 lg:px-8 lg:pb-28">
        <div class="absolute inset-0 overflow-hidden bg-navy"></div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-8 md:grid-cols-[1.05fr_0.95fr] md:gap-8 xl:gap-16">
            <div class="z-10 text-white">
                <p class="mb-4 inline-flex max-w-full items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.12em] text-gold backdrop-blur-md sm:mb-8 sm:px-4 sm:py-2 sm:text-xs sm:tracking-[0.15em]">
                    <span class="relative flex h-1.5 w-1.5 shrink-0 sm:h-2 sm:w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold opacity-75"></span><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-gold sm:h-2 sm:w-2"></span></span>
                    <span class="truncate">{{ $currentPlatform ? $currentPlatform['name'] : 'Catalogue de Services Premium' }}</span>
                </p>
                <h1 class="max-w-4xl text-[2.35rem] font-black leading-[1.02] tracking-normal sm:text-6xl xl:text-[80px]">
                    {{ $currentPlatform ? $currentPlatform['headline'] : 'Choisissez votre' }} <br>
                    <span class="bg-gradient-to-r from-white via-white to-gold bg-clip-text text-transparent">{{ $currentPlatform ? 'disponibles' : 'Plateforme' }}</span>
                </h1>
                <p class="mt-4 max-w-xl text-sm font-medium leading-7 text-white/65 sm:mt-8 sm:text-xl sm:leading-9">
                    {{ $currentPlatform ? $currentPlatform['description'] : 'TikTok, Facebook ou YouTube : choisissez une plateforme, puis consultez uniquement les comptes correspondants.' }}
                </p>
                <div class="mt-6 grid grid-cols-1 gap-2 sm:mt-10 sm:flex sm:flex-row sm:items-center sm:gap-5 lg:mt-12">
                    @if($currentPlatform)
                        <a href="#accounts" class="rounded-full bg-gold px-6 py-3.5 text-center text-xs font-black text-navy shadow-gold transition hover:scale-105 sm:px-10 sm:py-5 sm:text-sm">Voir les comptes</a>
                        <a href="{{ route('service') }}" class="rounded-full border border-white/20 bg-white/5 px-6 py-3.5 text-center text-xs font-black text-white backdrop-blur-md transition hover:bg-white/10 sm:px-10 sm:py-5 sm:text-sm">Toutes les plateformes</a>
                    @else
                        <a href="#platforms" class="rounded-full bg-gold px-6 py-3.5 text-center text-xs font-black text-navy shadow-gold transition hover:scale-105 sm:px-10 sm:py-5 sm:text-sm">Choisir une plateforme</a>
                        <a href="{{ route('catalog', ['type' => 'service']) }}" class="rounded-full border border-white/20 bg-white/5 px-6 py-3.5 text-center text-xs font-black text-white backdrop-blur-md transition hover:bg-white/10 sm:px-10 sm:py-5 sm:text-sm">Tout le catalogue</a>
                    @endif
                </div>
            </div>

            <div class="relative w-full max-w-md justify-self-center perspective-1000 md:max-w-none">
                <div class="relative z-10 overflow-hidden rounded-[1.75rem] border border-white/10 bg-navy/55 p-4 shadow-2xl backdrop-blur-2xl md:p-5 xl:animate-float xl:rounded-[2.5rem] xl:bg-white/[0.03] xl:p-8">
                    <div class="mb-5 flex items-center justify-between gap-4 sm:mb-8">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2"><span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-400"></span><p class="truncate text-[10px] font-black uppercase tracking-[0.14em] text-white/60">Selection rapide</p></div>
                            <h2 class="mt-1 text-xl font-black text-white sm:text-3xl">{{ $currentPlatform ? $currentPlatform['name'] : 'Services' }}</h2>
                        </div>
                        <span class="grid h-12 w-12 shrink-0 place-items-center">
                            @if($currentPlatform)
                                <x-social-logo :name="$currentPlatform['logo']" class="h-9 w-9" />
                            @else
                                <x-icon name="briefcase" class="h-8 w-8 text-gold" />
                            @endif
                        </span>
                    </div>

                    <div class="grid gap-2 sm:gap-4">
                        @foreach($platforms as $slug => $platform)
                            <a href="{{ route('service.platform', $slug) }}" class="rounded-2xl border border-white/5 bg-white/[0.05] p-3 transition hover:-translate-y-1 hover:bg-white/[0.09] sm:rounded-3xl sm:p-4">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center sm:h-12 sm:w-12"><x-social-logo :name="$platform['logo']" class="h-7 w-7 sm:h-8 sm:w-8" /></span>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-black text-white sm:text-base">{{ $platform['headline'] }}</p>
                                        <p class="truncate text-[11px] font-bold text-white/60 sm:text-xs">{{ ($platformCounts[$slug] ?? 0) ?: $platform['fallback_count'] }} actifs</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(! $selectedPlatform)
        <section class="bg-white px-4 py-12 sm:px-6 sm:py-20 lg:px-8" id="platforms">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 max-w-3xl">
                    <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Services par plateforme</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-navy sm:text-5xl">Un bloc clair pour chaque type de compte.</h2>
                    <p class="mt-4 text-sm font-semibold leading-7 text-slate-500 sm:text-base">choisi ta plateforme et opte pour ton service.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                    @foreach($platforms as $slug => $platform)
                        <a href="{{ route('service.platform', $slug) }}" class="premium-card group overflow-hidden rounded-[1.5rem] p-5 transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem] sm:p-7">
                            <div class="mb-7 flex items-start justify-between gap-4">
                                <span class="grid h-14 w-14 shrink-0 place-items-center"><x-social-logo :name="$platform['logo']" class="h-12 w-12" /></span>
                                <span class="rounded-full bg-gold/20 px-3 py-1 text-xs font-black text-[#805B08]">{{ ($platformCounts[$slug] ?? 0) ?: $platform['fallback_count'] }} actifs</span>
                            </div>
                            <h3 class="text-2xl font-black leading-tight text-navy">{{ $platform['headline'] }}</h3>
                            <p class="mt-3 min-h-20 text-sm font-semibold leading-7 text-slate-500">{{ $platform['description'] }}</p>
                            <div class="mt-6 grid gap-2">
                                <div class="rounded-2xl bg-mist p-4">
                                    <p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400">Orientation</p>
                                    <p class="mt-1 text-sm font-black text-navy">{{ $platform['metric'] }}</p>
                                </div>
                            </div>
                            <span class="mt-6 inline-flex rounded-full bg-royal px-5 py-3 text-xs font-black text-white shadow-glow transition group-hover:bg-navy">Voir les comptes {{ $platform['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="bg-white px-4 py-12 sm:px-6 sm:py-20 lg:px-8" id="accounts">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                    <div class="max-w-3xl">
                        <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">{{ $currentPlatform['name'] }}</p>
                        <h2 class="mt-3 text-3xl font-black leading-tight text-navy sm:text-5xl">{{ $currentPlatform['headline'] }} uniquement.</h2>
                        <p class="mt-4 text-sm font-semibold leading-7 text-slate-500 sm:text-base">Tous les produits ci-dessous concernent uniquement {{ $currentPlatform['name'] }}.</p>
                    </div>
                    <a href="{{ route('service') }}" class="w-fit rounded-full bg-navy px-5 py-3 text-xs font-black text-white shadow-premium sm:px-6 sm:py-4 sm:text-sm">Changer de plateforme</a>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse($serviceProducts as $product)
                        <article class="premium-card rounded-[1.5rem] p-4 transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem] sm:p-7">
                            <div class="mb-6 flex items-start justify-between gap-3">
                                <span class="grid h-12 w-12 shrink-0 place-items-center"><x-social-logo :name="$currentPlatform['logo']" class="h-9 w-9" /></span>
                                <span class="rounded-full bg-gold/20 px-3 py-1 text-[10px] font-black text-[#805B08] sm:text-xs">Disponible</span>
                            </div>
                            <h3 class="min-h-10 text-sm font-black leading-tight text-navy sm:text-2xl">{{ $product->title }}</h3>
                            <p class="mt-3 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $product->description }}</p>
                            <div class="mt-5 grid gap-2 sm:grid-cols-2">
                                <div class="rounded-2xl bg-mist p-3"><p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400">Type</p><p class="mt-1 text-xs font-black text-navy">Service</p></div>
                                <div class="rounded-2xl bg-mist p-3"><p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400">Plateforme</p><p class="mt-1 text-xs font-black text-navy">{{ $currentPlatform['name'] }}</p></div>
                            </div>
                            <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <span class="text-xs font-black text-navy sm:text-lg">{{ $product->formatted_price }}</span>
                                <a href="{{ route('products.show', $product) }}" class="rounded-full bg-royal px-4 py-2 text-center text-xs font-black text-white shadow-glow">Acheter</a>
                            </div>
                        </article>
                    @empty
                        @foreach($fallbackProducts[$selectedPlatform] as [$title, $logo, $description, $followers, $status, $price, $image, $linkedProduct])
                            <article class="overflow-hidden rounded-[1.5rem] bg-white shadow-premium transition hover:-translate-y-2 sm:rounded-[2rem]">
                                <div class="relative flex min-h-[150px] items-center justify-center overflow-hidden bg-navy sm:min-h-[220px]">
                                    <img src="{{ asset($image) }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div>
                                    <span class="relative grid h-14 w-14 place-items-center drop-shadow-[0_8px_20px_rgba(0,0,0,0.45)]"><x-social-logo :name="$logo" class="h-10 w-10" /></span>
                                    <h3 class="absolute bottom-5 left-5 right-5 text-base font-black leading-tight text-white sm:text-2xl">{{ $title }}</h3>
                                </div>
                                <div class="p-4 sm:p-7">
                                    <p class="line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $description }}</p>
                                    <div class="mt-5 grid gap-2 sm:grid-cols-2">
                                        <div class="rounded-2xl bg-mist p-3"><p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400">Audience</p><p class="mt-1 text-xs font-black text-navy">{{ $followers }}</p></div>
                                        <div class="rounded-2xl bg-mist p-3"><p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400">Statut</p><p class="mt-1 text-xs font-black text-navy">{{ $status }}</p></div>
                                    </div>
                                    <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                        <span class="text-xs font-black text-navy sm:text-lg">{{ $linkedProduct?->formatted_price ?? $price }}</span>
                                        <a href="{{ $linkedProduct ? route('products.show', $linkedProduct) : route('catalog', ['type' => 'service']) }}" class="rounded-full bg-navy px-4 py-2 text-center text-xs font-black text-white shadow-premium">Voir detail</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>
    @endif
@endsection
