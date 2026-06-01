@extends('layouts.app')

@section('title', 'Services - ' . config('app.name', '[NOM_DU_SITE]'))

@section('content')
    @php
        $platforms = $platforms ?? [
            'tiktok' => ['name' => 'TikTok', 'logo' => 'tiktok', 'headline' => 'Comptes TikTok', 'description' => 'Comptes TikTok monetises ou de demarrage.', 'fallback_count' => '50+', 'metric' => 'Videos courtes', 'keywords' => ['tiktok']],
            'facebook' => ['name' => 'Facebook', 'logo' => 'facebook', 'headline' => 'Pages Facebook', 'description' => 'Pages Facebook monetisees et actives.', 'fallback_count' => '20+', 'metric' => 'Reels & audience', 'keywords' => ['facebook', 'page']],
            'youtube' => ['name' => 'YouTube', 'logo' => 'youtube', 'headline' => 'Chaines YouTube', 'description' => 'Chaines YouTube monetisees ou starter.', 'fallback_count' => '30+', 'metric' => 'AdSense & contenu', 'keywords' => ['youtube', 'chaine', 'channel']],
        ];
        $selectedPlatform = $selectedPlatform ?? null;
        $currentPlatform = $selectedPlatform ? $platforms[$selectedPlatform] : null;
        $platformStyles = [
            'tiktok' => [
                'accent' => 'bg-[#111827]',
                'soft' => 'border-slate-200 bg-slate-50 text-slate-800',
                'label' => 'TikTok',
            ],
            'facebook' => [
                'accent' => 'bg-[#1877F2]',
                'soft' => 'border-blue-100 bg-blue-50 text-blue-700',
                'label' => 'Facebook',
            ],
            'youtube' => [
                'accent' => 'bg-[#FF0000]',
                'soft' => 'border-red-100 bg-red-50 text-red-700',
                'label' => 'YouTube',
            ],
        ];
        $currentStyle = $selectedPlatform ? ($platformStyles[$selectedPlatform] ?? $platformStyles['tiktok']) : null;
        $platformTags = [
            'tiktok' => ['Monetises', 'Starter', 'Niches'],
            'facebook' => ['Pages', 'Reels', 'Verified'],
            'youtube' => ['AdSense', 'Starter', 'Chaines'],
        ];

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

        $fallbackRows = [];
        foreach ($fallbackProducts as $platformSlug => $items) {
            foreach ($items as $item) {
                $fallbackRows[] = array_merge([$platformSlug], $item);
            }
        }

        $visibleFallbackRows = $selectedPlatform
            ? array_map(fn (array $item): array => array_merge([$selectedPlatform], $item), $fallbackProducts[$selectedPlatform] ?? [])
            : $fallbackRows;

        $detectServicePlatform = function ($product) use ($platforms): string {
            $text = \Illuminate\Support\Str::lower($product->title . ' ' . $product->slug . ' ' . $product->description);

            foreach ($platforms as $slug => $platform) {
                foreach (($platform['keywords'] ?? [$slug]) as $keyword) {
                    if (str_contains($text, \Illuminate\Support\Str::lower($keyword))) {
                        return $slug;
                    }
                }
            }

            return 'tiktok';
        };

        $serviceCount = $serviceProducts->count() ?: count($visibleFallbackRows);
    @endphp

    <section class="bg-mist px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @if($selectedPlatform)
                <div class="overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-premium sm:rounded-[2rem]">
                    <span class="block h-1.5 {{ $currentStyle['accent'] }}"></span>
                    <div class="grid gap-5 p-5 sm:p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                            <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl border {{ $currentStyle['soft'] }} sm:h-16 sm:w-16">
                                <x-social-logo :name="$currentPlatform['logo']" class="h-9 w-9 sm:h-10 sm:w-10" />
                            </span>

                            <div>
                                <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-400 sm:text-xs">
                                    Services / {{ $currentPlatform['name'] }}
                                </p>
                                <h1 class="mt-1 text-2xl font-black leading-tight text-navy sm:text-4xl">
                                    {{ $currentPlatform['headline'] }}
                                </h1>
                                <p class="mt-2 max-w-3xl text-sm font-semibold leading-7 text-slate-500">
                                    {{ $currentPlatform['description'] }}
                                </p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($platformTags[$selectedPlatform] ?? [] as $tag)
                                        <span class="rounded-full border px-3 py-1 text-[10px] font-black {{ $currentStyle['soft'] }}">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 lg:flex-col lg:items-end">
                            <span class="w-fit rounded-full bg-mist px-5 py-3 text-xs font-black text-royal sm:text-sm">
                                {{ $serviceCount }} service{{ $serviceCount > 1 ? 's' : '' }}
                            </span>
                            <span class="rounded-full border px-4 py-2 text-[10px] font-black {{ $currentStyle['soft'] }}">
                                {{ $currentPlatform['metric'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Comptes sociaux</p>
                      
                        <p class="mt-3 text-sm font-semibold leading-7 text-slate-500">
                            TikTok, Facebook ou YouTube: selectionnez une plateforme pour voir les comptes disponibles.
                        </p>
                    </div>
                    <span class="w-fit rounded-full bg-white px-5 py-3 text-xs font-black text-royal shadow-soft sm:text-sm">
                        {{ count($platforms) }} plateformes disponibles
                    </span>
                </div>
            @endif

            @if($selectedPlatform)
                <div class="mt-6 grid gap-3 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-premium sm:rounded-[2rem] sm:p-5 lg:grid-cols-[1fr_auto] lg:items-center">
                    <label class="grid gap-2 text-sm font-black text-navy">
                        Rechercher
                        <input
                            type="search"
                            class="h-12 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white"
                            placeholder="Rechercher dans {{ $currentPlatform['name'] ?? 'les services' }}..."
                            data-service-search
                        >
                    </label>

                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('service') }}" class="rounded-xl bg-mist px-4 py-3 text-xs font-black text-navy transition hover:bg-royal hover:text-white sm:px-5">Toutes les plateformes</a>
                        @foreach($platforms as $slug => $platform)
                            <a href="{{ route('service.platform', $slug) }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-xs font-black transition sm:px-5 {{ $selectedPlatform === $slug ? 'bg-royal text-white shadow-glow' : 'bg-mist text-navy hover:bg-royal hover:text-white' }}">
                                <span class="grid h-5 w-5 place-items-center"><x-social-logo :name="$platform['logo']" class="h-4 w-4" /></span>
                                {{ $platform['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @unless($selectedPlatform)
                <div class="mt-8 grid gap-3 sm:grid-cols-3 sm:gap-5">
                    @foreach($platforms as $slug => $platform)
                        @php
                            $style = $platformStyles[$slug] ?? $platformStyles['tiktok'];
                        @endphp
                        <a href="{{ route('service.platform', $slug) }}" class="group overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-soft transition hover:-translate-y-1 hover:shadow-premium sm:rounded-[2rem]">
                            <span class="block h-1.5 {{ $style['accent'] }}"></span>
                            <div class="p-4 sm:p-6">
                            <div class="flex items-start justify-between gap-4">
                                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl border {{ $style['soft'] }}"><x-social-logo :name="$platform['logo']" class="h-8 w-8" /></span>
                                <span class="rounded-full bg-gold/20 px-3 py-1 text-[10px] font-black text-[#805B08] sm:text-xs">{{ ($platformCounts[$slug] ?? 0) ?: $platform['fallback_count'] }} actifs</span>
                            </div>
                            <h2 class="mt-5 text-xl font-black leading-tight text-navy sm:text-2xl">{{ $platform['headline'] }}</h2>
                            <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500 sm:text-sm sm:leading-6">{{ $platform['description'] }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($platformTags[$slug] ?? [] as $tag)
                                    <span class="rounded-full border px-3 py-1 text-[10px] font-black {{ $style['soft'] }}">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <span class="mt-5 inline-flex rounded-full bg-royal px-4 py-2.5 text-xs font-black text-white shadow-glow transition group-hover:bg-navy">Voir {{ $platform['name'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endunless

            @if($selectedPlatform)
                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-3 xl:grid-cols-4" data-service-grid>
                    @forelse($serviceProducts as $product)
                        @php
                            $platformSlug = $selectedPlatform ?: $detectServicePlatform($product);
                            $platform = $platforms[$platformSlug] ?? $platforms['tiktok'];
                            $style = $platformStyles[$platformSlug] ?? $platformStyles['tiktok'];
                        @endphp
                        <article
                            class="group overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-premium transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]"
                            data-service-card
                            data-search="{{ \Illuminate\Support\Str::lower($product->title . ' ' . $product->description . ' ' . $platform['name']) }}"
                        >
                            <div class="relative h-36 overflow-hidden bg-navy sm:h-56">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/assets/training/digital-products.jpg') }}" alt="{{ $product->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div>
                                <span class="absolute bottom-3 left-3 grid h-10 w-10 place-items-center sm:bottom-5 sm:left-5 sm:h-12 sm:w-12"><x-social-logo :name="$platform['logo']" class="h-8 w-8 sm:h-10 sm:w-10" /></span>
                                @if($product->is_on_promotion)
                                    <span class="absolute right-3 top-3 rounded-full bg-rose-600 px-3 py-1 text-[10px] font-black text-white shadow-premium sm:text-xs">Promo</span>
                                @endif
                            </div>

                            <div class="p-4 sm:p-6">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-[10px] font-black sm:text-xs {{ $style['soft'] }}"><x-social-logo :name="$platform['logo']" class="h-3.5 w-3.5" />{{ $platform['name'] }}</span>
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black text-emerald-700 sm:text-xs">Disponible</span>
                                </div>
                                <h2 class="mt-3 min-h-10 text-sm font-black leading-tight text-navy sm:text-xl">{{ $product->title }}</h2>
                                <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $product->description }}</p>
                            </div>

                            <div class="flex flex-col gap-3 border-t border-slate-100 p-4 sm:p-6">
                                <x-product-price :product="$product" />
                                <a href="{{ route('products.show', $product) }}" class="rounded-full bg-royal px-4 py-2.5 text-center text-xs font-black text-white shadow-glow transition hover:bg-navy">Voir detail</a>
                            </div>
                        </article>
                    @empty
                        @foreach($visibleFallbackRows as [$platformSlug, $title, $logo, $description, $followers, $status, $price, $image, $linkedProduct])
                            @php
                                $platform = $platforms[$platformSlug] ?? $platforms['tiktok'];
                                $style = $platformStyles[$platformSlug] ?? $platformStyles['tiktok'];
                            @endphp
                            <article
                                class="group overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-premium transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]"
                                data-service-card
                                data-search="{{ \Illuminate\Support\Str::lower($title . ' ' . $description . ' ' . $platform['name'] . ' ' . $status) }}"
                            >
                                <div class="relative h-36 overflow-hidden bg-navy sm:h-56">
                                    <img src="{{ asset($image) }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div>
                                    <span class="absolute bottom-3 left-3 grid h-10 w-10 place-items-center sm:bottom-5 sm:left-5 sm:h-12 sm:w-12"><x-social-logo :name="$logo" class="h-8 w-8 sm:h-10 sm:w-10" /></span>
                                    @if($linkedProduct?->is_on_promotion)
                                        <span class="absolute right-3 top-3 rounded-full bg-rose-600 px-3 py-1 text-[10px] font-black text-white shadow-premium sm:text-xs">Promo</span>
                                    @endif
                                </div>

                                <div class="p-4 sm:p-6">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-[10px] font-black sm:text-xs {{ $style['soft'] }}"><x-social-logo :name="$logo" class="h-3.5 w-3.5" />{{ $platform['name'] }}</span>
                                        <span class="rounded-full bg-gold/20 px-3 py-1 text-[10px] font-black text-[#805B08] sm:text-xs">{{ $status }}</span>
                                    </div>
                                    <h2 class="mt-3 min-h-10 text-sm font-black leading-tight text-navy sm:text-xl">{{ $title }}</h2>
                                    <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $description }}</p>
                                    <p class="mt-3 text-[10px] font-black uppercase tracking-[0.14em] text-slate-400">{{ $followers }}</p>
                                </div>

                                <div class="flex flex-col gap-3 border-t border-slate-100 p-4 sm:p-6">
                                    @if($linkedProduct)
                                        <x-product-price :product="$linkedProduct" />
                                    @else
                                        <span class="text-xs font-black text-navy sm:text-lg">{{ $price }}</span>
                                    @endif
                                    <a href="{{ $linkedProduct ? route('products.show', $linkedProduct) : route('catalog', ['type' => 'service']) }}" class="rounded-full bg-royal px-4 py-2.5 text-center text-xs font-black text-white shadow-glow transition hover:bg-navy">Voir detail</a>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                </div>

                <div class="mt-8 hidden rounded-[1.5rem] border border-slate-200 bg-white px-5 py-8 text-center shadow-premium" data-service-empty>
                    <p class="text-sm font-black text-navy">Aucun service ne correspond a votre recherche.</p>
                    <p class="mt-2 text-xs font-semibold text-slate-500">Essayez un autre mot-cle ou changez de plateforme.</p>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const search = document.querySelector('[data-service-search]');
                const grid = document.querySelector('[data-service-grid]');
                const emptyState = document.querySelector('[data-service-empty]');

                if (!search || !grid) return;

                const cards = Array.from(grid.querySelectorAll('[data-service-card]'));

                const applySearch = () => {
                    const query = search.value.trim().toLowerCase();
                    let visibleCount = 0;

                    cards.forEach((card) => {
                        const visible = !query || (card.dataset.search || '').includes(query);

                        card.classList.toggle('hidden', !visible);
                        if (visible) visibleCount += 1;
                    });

                    emptyState?.classList.toggle('hidden', visibleCount !== 0);
                };

                search.addEventListener('input', applySearch);
                applySearch();
            });
        </script>
    @endpush
@endsection
