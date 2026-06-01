@extends('layouts.app')

@section('title', 'Formations - ' . config('app.name', '[NOM_DU_SITE]'))

@section('content')
    @php
        $fallbackCourses = [
            ['Masterclass Trading Crypto', 'Crypto', 'Signaux, entrees, sorties, gestion des risques et structure de marche pour operateurs actifs.', '299 000 FCFA', '/assets/training/crypto-masterclass.jpg'],
            ['TikTok Monetisation Blueprint', 'Social', 'Creez des moteurs de contenu court, qualifiez vos comptes et transformez l attention en revenus.', '209 000 FCFA', '/assets/training/tiktok-blueprint.jpg'],
            ['Croissance Chaine YouTube', 'Video', 'Recherche de niche, systemes de retention, miniatures, SEO et operations de chaines monetisees.', '179 000 FCFA', '/assets/training/youtube-growth.jpg'],
            ['Maitrise Facebook Ads', 'Ads', 'Structures de campagne pour la vente de comptes, tunnels de formation et produits digitaux.', '209 000 FCFA', '/assets/training/facebook-ads.jpg'],
            ['Vente de Produits Digitaux', 'Business', 'Architecture d offre, tunnels de vente, lancements partenaires et positionnement premium.', '149 000 FCFA', '/assets/training/digital-products.jpg'],
            ['Creation Video IA Virale', 'Video', 'Scripts, voix et montage automatise pour videos virales TikTok et Reels.', '119 000 FCFA', '/assets/training/tech2.avif'],
        ];

        $detectCourseCategory = function (string $title, ?string $description = null): string {
            $text = \Illuminate\Support\Str::lower($title . ' ' . $description);

            if (str_contains($text, 'crypto') || str_contains($text, 'trading')) {
                return 'Crypto';
            }

            if (str_contains($text, 'ads') || str_contains($text, 'publicite') || str_contains($text, 'campagne')) {
                return 'Ads';
            }

            if (str_contains($text, 'youtube') || str_contains($text, 'video') || str_contains($text, 'reels') || str_contains($text, 'montage')) {
                return 'Video';
            }

            if (str_contains($text, 'business') || str_contains($text, 'vente') || str_contains($text, 'produit digital')) {
                return 'Business';
            }

            return 'Social';
        };

        $courseCount = $formationProducts->count() ?: count($fallbackCourses);
    @endphp

    <section class="bg-mist px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Formations</p>
                    <h1 class="mt-2 text-3xl font-black leading-tight text-navy sm:text-5xl">Toutes les formations.</h1>
                    <p class="mt-3 text-sm font-semibold leading-7 text-slate-500">
                        Recherchez une formation, filtrez par categorie et ouvrez directement les details.
                    </p>
                </div>
                <span class="w-fit rounded-full bg-white px-5 py-3 text-xs font-black text-royal shadow-soft sm:text-sm">
                    {{ $courseCount }} formation{{ $courseCount > 1 ? 's' : '' }}
                </span>
            </div>

            <div class="mt-6 grid gap-3 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-premium sm:rounded-[2rem] sm:p-5 lg:grid-cols-[1fr_auto] lg:items-center">
                <label class="grid gap-2 text-sm font-black text-navy">
                    Rechercher
                    <input
                        type="search"
                        class="h-12 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white"
                        placeholder="Crypto, TikTok, YouTube, business..."
                        data-training-search
                    >
                </label>

                <div class="flex flex-wrap items-center gap-2" data-training-filters>
                    @foreach(['Tout', 'Crypto', 'Social', 'Video', 'Ads', 'Business'] as $category)
                        <button type="button" class="rounded-xl bg-mist px-4 py-3 text-xs font-black text-navy transition hover:bg-royal hover:text-white sm:px-5" data-training-filter="{{ $category }}" aria-pressed="{{ $category === 'Tout' ? 'true' : 'false' }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-3 xl:grid-cols-4" data-training-grid>
                @forelse($formationProducts as $product)
                    @php($category = $detectCourseCategory($product->title, $product->description))
                    <article
                        class="group overflow-hidden rounded-[1.35rem] bg-white shadow-premium transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]"
                        data-training-card
                        data-category="{{ $category }}"
                        data-search="{{ \Illuminate\Support\Str::lower($product->title . ' ' . $product->description . ' ' . $category) }}"
                    >
                        <div class="relative h-36 overflow-hidden bg-navy sm:h-56">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/assets/training/crypto-masterclass.jpg') }}" alt="{{ $product->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div>
                            <span class="absolute bottom-3 left-3 rounded-full bg-white/10 px-3 py-1 text-[10px] font-black text-gold backdrop-blur sm:bottom-5 sm:left-5 sm:text-xs">{{ $category }}</span>
                            @if($product->is_on_promotion)
                                <span class="absolute right-3 top-3 rounded-full bg-rose-600 px-3 py-1 text-[10px] font-black text-white shadow-premium sm:text-xs">Promo</span>
                            @endif
                        </div>

                        <div class="p-4 sm:p-6">
                            <h2 class="min-h-10 text-sm font-black leading-tight text-navy sm:text-xl">{{ $product->title }}</h2>
                            <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $product->description }}</p>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-slate-100 p-4 sm:p-6">
                            <x-product-price :product="$product" />
                            <a href="{{ route('products.show', $product) }}" class="rounded-full bg-royal px-4 py-2.5 text-center text-xs font-black text-white shadow-glow transition hover:bg-navy">Voir la formation</a>
                        </div>
                    </article>
                @empty
                    @foreach($fallbackCourses as [$title, $category, $description, $price, $image])
                        <article
                            class="group overflow-hidden rounded-[1.35rem] bg-white shadow-premium transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]"
                            data-training-card
                            data-category="{{ $category }}"
                            data-search="{{ \Illuminate\Support\Str::lower($title . ' ' . $description . ' ' . $category) }}"
                        >
                            <div class="relative h-36 overflow-hidden bg-navy sm:h-56">
                                <img src="{{ asset($image) }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div>
                                <span class="absolute bottom-3 left-3 rounded-full bg-white/10 px-3 py-1 text-[10px] font-black text-gold backdrop-blur sm:bottom-5 sm:left-5 sm:text-xs">{{ $category }}</span>
                            </div>

                            <div class="p-4 sm:p-6">
                                <h2 class="min-h-10 text-sm font-black leading-tight text-navy sm:text-xl">{{ $title }}</h2>
                                <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $description }}</p>
                            </div>

                            <div class="flex flex-col gap-3 border-t border-slate-100 p-4 sm:p-6">
                                <span class="text-xs font-black text-navy sm:text-lg">{{ $price }}</span>
                                <a href="{{ route('catalog') }}" class="rounded-full bg-royal px-4 py-2.5 text-center text-xs font-black text-white shadow-glow transition hover:bg-navy">Voir les offres</a>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            <div class="mt-8 hidden rounded-[1.5rem] border border-slate-200 bg-white px-5 py-8 text-center shadow-premium" data-training-empty>
                <p class="text-sm font-black text-navy">Aucune formation ne correspond a votre recherche.</p>
                <p class="mt-2 text-xs font-semibold text-slate-500">Essayez un autre mot-cle ou revenez sur Tout.</p>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filters = document.querySelector('[data-training-filters]');
                const search = document.querySelector('[data-training-search]');
                const grid = document.querySelector('[data-training-grid]');
                const emptyState = document.querySelector('[data-training-empty]');

                if (!filters || !grid) return;

                const buttons = Array.from(filters.querySelectorAll('[data-training-filter]'));
                const cards = Array.from(grid.querySelectorAll('[data-training-card]'));
                let selectedCategory = 'Tout';

                const setActiveButton = () => {
                    buttons.forEach((button) => {
                        const active = button.dataset.trainingFilter === selectedCategory;

                        button.setAttribute('aria-pressed', active ? 'true' : 'false');
                        button.classList.toggle('bg-royal', active);
                        button.classList.toggle('text-white', active);
                        button.classList.toggle('shadow-glow', active);
                        button.classList.toggle('bg-mist', !active);
                        button.classList.toggle('text-navy', !active);
                    });
                };

                const applyFilters = () => {
                    const query = (search?.value || '').trim().toLowerCase();
                    let visibleCount = 0;

                    cards.forEach((card) => {
                        const categoryMatch = selectedCategory === 'Tout' || card.dataset.category === selectedCategory;
                        const searchMatch = !query || (card.dataset.search || '').includes(query);
                        const visible = categoryMatch && searchMatch;

                        card.classList.toggle('hidden', !visible);
                        if (visible) visibleCount += 1;
                    });

                    emptyState?.classList.toggle('hidden', visibleCount !== 0);
                    setActiveButton();
                };

                buttons.forEach((button) => {
                    button.addEventListener('click', () => {
                        selectedCategory = button.dataset.trainingFilter || 'Tout';
                        applyFilters();
                    });
                });

                search?.addEventListener('input', applyFilters);
                applyFilters();
            });
        </script>
    @endpush
@endsection
