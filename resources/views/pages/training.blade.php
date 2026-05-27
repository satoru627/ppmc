@extends('layouts.app')

@section('title', 'Formations - ' . config('app.name', '[NOM_DU_SITE]'))
@section('nav_mode', 'dark')

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
    @endphp

    <section class="relative -mt-24 overflow-hidden px-4 pb-12 pt-32 sm:px-6 sm:pb-20 sm:pt-36 lg:px-8 lg:pb-32">
        <div class="absolute inset-0 overflow-hidden bg-navy">
        </div>
        <div class="relative mx-auto grid max-w-7xl grid-cols-[1.2fr_0.8fr] items-center gap-4 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
            <div class="z-10 text-white">
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.15em] text-gold backdrop-blur-md sm:mb-8 sm:px-4 sm:py-2 sm:text-xs">
                    <span class="relative flex h-1.5 w-1.5 sm:h-2 sm:w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold opacity-75"></span><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-gold sm:h-2 sm:w-2"></span></span>
                    Academie Premium
                </p>
                <h1 class="max-w-4xl text-3xl font-black leading-tight tracking-tight sm:text-6xl xl:text-[80px]">
                    Devenez un <br>
                    <span class="bg-gradient-to-r from-white via-white to-gold bg-clip-text text-transparent">Operateur d'Elite</span>
                </h1>
                <p class="mt-4 max-w-xl text-xs font-medium leading-relaxed text-white/60 sm:mt-8 sm:text-xl">Systemes de richesse digitale : Crypto, Createur, Acquisition.</p>
                <div class="mt-6 flex flex-col gap-2 sm:mt-12 sm:flex-row sm:items-center sm:gap-6">
                    <a href="#courses" class="rounded-full bg-gold px-6 py-3 text-center text-xs font-black text-navy shadow-gold transition hover:scale-105 sm:px-10 sm:py-5 sm:text-sm">Bibliotheque</a>
                    <a href="{{ route('contact') }}" class="rounded-full border border-white/20 bg-white/5 px-6 py-3 text-center text-xs font-black text-white backdrop-blur-md sm:px-10 sm:py-5 sm:text-sm">Conseil</a>
                </div>
                <div class="mt-8 grid max-w-xl grid-cols-3 gap-2 sm:mt-16 sm:gap-4">
                    @foreach([['6', 'cours'], ['42', 'mod.'], ['24/7', 'acces']] as [$value, $label])
                        <div class="rounded-xl border border-white/5 bg-white/[0.03] p-2 text-center backdrop-blur-xl sm:rounded-3xl sm:p-5"><p class="text-xl font-black text-white sm:text-3xl">{{ $value }}</p><p class="mt-1 text-[8px] font-bold uppercase tracking-widest text-white/40 sm:text-xs">{{ $label }}</p></div>
                    @endforeach
                </div>
            </div>
            <div class="relative perspective-1000">
                <div class="relative z-10 overflow-hidden rounded-3xl border border-white/10 bg-navy/40 p-3 shadow-2xl backdrop-blur-2xl animate-float md:p-5 xl:rounded-[2.5rem] xl:bg-white/[0.03] xl:p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <div><div class="flex items-center gap-2"><span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-400"></span><p class="text-[10px] font-black uppercase tracking-[0.15em] text-white/60">Espace Etudiant</p></div><h2 class="mt-2 text-2xl font-black text-white sm:text-3xl">Dashboard</h2></div>
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-royal to-navy text-gold shadow-lg"><x-icon name="book-open" class="h-6 w-6" /></div>
                    </div>
                    <div class="grid gap-5">
                        @foreach([['Crypto', '82%'], ['Createur', '64%'], ['Ads', '71%']] as [$label, $value])
                            <div><div class="mb-3 flex justify-between text-xs font-black"><span class="text-white/60">{{ $label }}</span><span class="text-gold">{{ $value }}</span></div><div class="h-2 overflow-hidden rounded-full bg-white/5 p-px"><div class="h-full rounded-full bg-gradient-to-r from-royal via-royal to-gold" style="width: {{ $value }}"></div></div></div>
                        @endforeach
                    </div>
                    <div class="mt-8 rounded-2xl border border-white/5 bg-white/5 p-5"><div class="mb-4 flex items-center justify-between"><p class="text-[10px] font-black uppercase tracking-widest text-white/40">Session Live</p><span class="h-2 w-2 rounded-full bg-gold shadow-gold"></span></div><p class="text-sm font-bold text-white">Q&A : Scaler TikTok</p></div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-12 sm:px-6 sm:py-20 lg:px-8" id="courses">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div><p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Formations Premium</p><h2 class="mt-3 max-w-2xl text-3xl font-black leading-tight text-navy sm:text-5xl">Apprenez les systemes derriere la richesse digitale.</h2></div>
                <a href="{{ route('contact') }}" class="w-fit rounded-full bg-white px-6 py-4 text-sm font-black text-royal shadow-premium">Parler a un conseiller</a>
            </div>
            <div class="mb-10 flex flex-wrap items-center gap-3" data-training-filters>
                <span class="mr-2 text-xs font-black uppercase tracking-widest text-slate-400">Filtrer par :</span>
                @foreach(['Tout', 'Crypto', 'Social', 'Video', 'Ads', 'Business'] as $category)
                    <button type="button" class="rounded-xl bg-white px-5 py-2.5 text-xs font-black text-navy transition hover:bg-royal hover:text-white sm:px-6 sm:py-3 sm:text-sm" data-training-filter="{{ $category }}" aria-pressed="{{ $category === 'Tout' ? 'true' : 'false' }}">{{ $category }}</button>
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-3 sm:gap-6 md:grid-cols-3 xl:grid-cols-4" data-training-grid>
                @forelse($formationProducts as $product)
                    @php($category = $detectCourseCategory($product->title, $product->description))
                    <article class="premium-card group overflow-hidden rounded-[1.5rem] transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]" data-training-card data-category="{{ $category }}">
                        <div class="relative min-h-[130px] overflow-hidden bg-gradient-to-br from-navy via-royal to-gold sm:min-h-[220px]"><img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/assets/training/crypto-masterclass.jpg') }}" alt="{{ $product->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"><div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div><span class="absolute bottom-5 left-5 rounded-full bg-white/10 px-3 py-1 text-xs font-black text-gold backdrop-blur">{{ $category }}</span></div>
                        <div class="p-4 sm:p-6"><h3 class="text-sm font-black leading-tight text-navy sm:text-xl">{{ $product->title }}</h3><p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $product->description }}</p></div>
                        <div class="flex items-center justify-between gap-3 border-t border-slate-100 p-4 sm:p-6"><span class="text-sm font-black text-navy sm:text-xl">{{ $product->formatted_price }}</span><a href="{{ route('products.show', $product) }}" class="rounded-full bg-royal px-4 py-2 text-xs font-black text-white shadow-glow">S'inscrire</a></div>
                    </article>
                @empty
                    @foreach($fallbackCourses as [$title, $category, $description, $price, $image])
                        <article class="premium-card group overflow-hidden rounded-[1.5rem] transition hover:-translate-y-2 hover:shadow-premium sm:rounded-[2rem]" data-training-card data-category="{{ $category }}">
                            <div class="relative min-h-[130px] overflow-hidden sm:min-h-[220px]"><img src="{{ asset($image) }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"><div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent"></div><span class="absolute bottom-5 left-5 rounded-full bg-white/10 px-3 py-1 text-xs font-black text-gold backdrop-blur">{{ $category }}</span></div>
                            <div class="p-4 sm:p-6"><h3 class="text-sm font-black leading-tight text-navy sm:text-xl">{{ $title }}</h3><p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500">{{ $description }}</p></div>
                            <div class="flex items-center justify-between gap-3 border-t border-slate-100 p-4 sm:p-6"><span class="text-sm font-black text-navy sm:text-xl">{{ $price }}</span><a href="{{ route('contact') }}" class="rounded-full bg-royal px-4 py-2 text-xs font-black text-white shadow-glow">S'inscrire</a></div>
                        </article>
                    @endforeach
                @endforelse
            </div>
            <div class="mt-8 hidden rounded-[1.5rem] border border-slate-200 bg-white px-5 py-8 text-center shadow-premium" data-training-empty>
                <p class="text-sm font-black text-navy">Aucune formation dans cette categorie pour le moment.</p>
                <p class="mt-2 text-xs font-semibold text-slate-500">Essayez un autre filtre ou revenez sur Tout.</p>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-training-filters]');
                const grid = document.querySelector('[data-training-grid]');
                const emptyState = document.querySelector('[data-training-empty]');

                if (!root || !grid) return;

                const buttons = Array.from(root.querySelectorAll('[data-training-filter]'));
                const cards = Array.from(grid.querySelectorAll('[data-training-card]'));

                const setActiveButton = (selected) => {
                    buttons.forEach((button) => {
                        const active = button.dataset.trainingFilter === selected;

                        button.setAttribute('aria-pressed', active ? 'true' : 'false');
                        button.classList.toggle('bg-royal', active);
                        button.classList.toggle('text-white', active);
                        button.classList.toggle('shadow-glow', active);
                        button.classList.toggle('bg-white', !active);
                        button.classList.toggle('text-navy', !active);
                    });
                };

                const applyFilter = (selected) => {
                    let visibleCount = 0;

                    cards.forEach((card) => {
                        const visible = selected === 'Tout' || card.dataset.category === selected;

                        card.classList.toggle('hidden', !visible);
                        if (visible) visibleCount += 1;
                    });

                    emptyState?.classList.toggle('hidden', visibleCount !== 0);
                    setActiveButton(selected);
                };

                buttons.forEach((button) => {
                    button.addEventListener('click', () => {
                        applyFilter(button.dataset.trainingFilter || 'Tout');
                    });
                });

                applyFilter('Tout');
            });
        </script>
    @endpush
@endsection
