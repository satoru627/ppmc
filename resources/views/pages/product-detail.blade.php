@extends('layouts.app')

@section('title', $product->title . ' - ' . config('app.name', '[NOM_DU_SITE]'))

@section('content')
    @php
        $isFormation = $product->type === 'formation';
        $image = $product->image
            ? asset('storage/' . $product->image)
            : asset($isFormation ? '/assets/training/crypto-masterclass.jpg' : '/assets/training/digital-products.jpg');
        $shortDescription = \Illuminate\Support\Str::limit($product->description, 180);
        $typeLabel = $isFormation ? 'Formation' : 'Service';
        $usesChariow = $product->hasChariowCheckout();
        $benefits = $isFormation
            ? [$usesChariow ? 'Acces gere sur Chariow' : 'Lien Chariow en preparation', 'Support pendant la mise en pratique', 'Facture PDF disponible', 'Telechargement securise']
            : [$usesChariow ? 'Commande geree sur Chariow' : 'Lien Chariow en preparation', 'Transfert accompagne', 'Support apres achat', 'Facture PDF disponible'];
        $steps = $usesChariow
            ? ['Redirection vers Chariow', 'Paiement dans la boutique', $isFormation ? 'Acces a la formation sur Chariow' : 'Traitement par Chariow']
            : ['Lien Chariow en preparation', 'Achat bientot disponible', 'Support disponible'];
    @endphp

    <section class="bg-mist px-4 py-10 sm:px-6 sm:py-16 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.16em] text-royal transition hover:text-navy">
                <x-icon name="arrow-right" class="h-4 w-4 rotate-180" />
                Retour au catalogue
            </a>

            <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_25rem] lg:items-start">
                <div class="overflow-hidden rounded-[1.75rem] bg-white shadow-premium sm:rounded-[2rem]">
                    <div class="relative min-h-[260px] overflow-hidden bg-navy sm:min-h-[460px]">
                        <img src="{{ $image }}" alt="{{ $product->title }}" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-navy/25 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 text-white sm:p-8">
                            <span class="inline-flex rounded-full bg-gold px-4 py-2 text-[10px] font-black uppercase tracking-[0.14em] text-navy">{{ $typeLabel }}</span>
                            <h1 class="mt-4 max-w-4xl text-3xl font-black leading-tight sm:text-6xl">{{ $product->title }}</h1>
                            <p class="mt-4 max-w-2xl text-sm font-semibold leading-7 text-white/70 sm:text-base">{{ $shortDescription }}</p>
                        </div>
                    </div>

                    <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-8 xl:grid-cols-4">
                        @foreach($benefits as $benefit)
                            <div class="rounded-2xl bg-mist p-4">
                                <x-icon name="check-circle" class="h-5 w-5 text-emerald-600" />
                                <p class="mt-3 text-sm font-black leading-5 text-navy">{{ $benefit }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <aside class="lg:sticky lg:top-28">
                    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-premium sm:rounded-[2rem] sm:p-6">
                        <div class="flex items-center justify-between gap-4">
                            <span class="rounded-full bg-royal/10 px-4 py-2 text-xs font-black uppercase tracking-[0.14em] text-royal">{{ $typeLabel }}</span>
                            <span class="rounded-full bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700">Disponible</span>
                        </div>

                        <div class="mt-6 rounded-3xl bg-mist p-5">
                            <p class="text-xs font-black uppercase tracking-[0.14em] text-slate-400">Prix</p>
                            <p class="mt-2 text-3xl font-black text-navy sm:text-4xl">{{ $product->formatted_price }}</p>
                            <p class="mt-2 text-xs font-bold text-slate-500">{{ $usesChariow ? 'Paiement et acces finalises dans notre boutique Chariow.' : 'Ce produit sera disponible des que le lien Chariow sera configure.' }}</p>
                        </div>

                        <div class="mt-5 grid gap-3">
                            @if($usesChariow)
                                <a href="{{ route('products.buy', $product) }}" class="rounded-full bg-royal px-6 py-4 text-center text-sm font-black text-white shadow-glow transition hover:-translate-y-1 hover:bg-navy">{{ auth()->check() ? 'Acheter maintenant' : 'Se connecter pour acheter' }}</a>
                            @else
                                <span class="rounded-full bg-slate-200 px-6 py-4 text-center text-sm font-black text-slate-500">Produit bientot disponible</span>
                            @endif
                            <a href="{{ route('service') }}" class="rounded-full border border-slate-200 px-6 py-4 text-center text-sm font-black text-navy transition hover:border-royal hover:text-royal">Voir les services</a>
                        </div>

                        <div class="mt-6 grid gap-3 border-t border-slate-100 pt-5">
                            @foreach($steps as $index => $step)
                                <div class="flex items-center gap-3">
                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-gold/20 text-xs font-black text-[#805B08]">{{ $index + 1 }}</span>
                                    <p class="text-sm font-bold text-slate-600">{{ $step }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_0.75fr]">
                <section class="rounded-[1.75rem] bg-white p-5 shadow-soft sm:rounded-[2rem] sm:p-8">
                    <p class="text-sm font-black uppercase tracking-[0.16em] text-royal">Description</p>
                    <h2 class="mt-3 text-2xl font-black text-navy sm:text-4xl">Ce que vous obtenez.</h2>
                    <p class="mt-5 whitespace-pre-line text-sm font-semibold leading-8 text-slate-600">{{ $product->description }}</p>
                </section>

                <section class="rounded-[1.75rem] bg-white p-5 shadow-soft sm:rounded-[2rem] sm:p-8">
                    <p class="text-sm font-black uppercase tracking-[0.16em] text-royal">Confiance</p>
                    <div class="mt-5 grid gap-3">
                        @foreach(['Paiement securise', 'Support client', 'Facture PDF', 'Acces protege'] as $item)
                            <div class="flex items-center gap-3 rounded-2xl bg-mist p-4">
                                <x-icon name="shield" class="h-5 w-5 text-royal" />
                                <span class="text-sm font-black text-navy">{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
