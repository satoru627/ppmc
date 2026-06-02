@extends('layouts.app')

@section('title', 'Catalogue - ' . config('app.name', '[NOM_DU_SITE]'))

@section('content')
    @php($offerCount = $products->total())

    <section class="bg-mist px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Catalogue</p>
                  
                    <p class="mt-3 text-sm font-semibold leading-7 text-slate-500">
                        Recherchez une formation ou un service, filtrez par type et ouvrez directement les details.
                    </p>
                </div>
                <span class="w-fit rounded-full bg-white px-5 py-3 text-xs font-black text-royal shadow-soft sm:text-sm">
                    {{ $offerCount }} offre{{ $offerCount > 1 ? 's' : '' }}
                </span>
            </div>

            <form method="GET" action="{{ route('catalog') }}" class="mt-6 grid gap-3 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-premium sm:rounded-[2rem] sm:p-5 md:grid-cols-[1fr_220px_auto]">
                <input name="search" value="{{ request('search') }}" class="h-12 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none focus:border-royal focus:bg-white" placeholder="Rechercher une formation ou un service">
                <select name="type" class="h-12 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-bold outline-none focus:border-royal focus:bg-white">
                    <option value="">Tous les types</option>
                    <option value="formation" @selected(request('type') === 'formation')>Formations</option>
                    <option value="service" @selected(request('type') === 'service')>Services</option>
                </select>
                <button class="h-12 rounded-2xl bg-royal px-6 text-sm font-black text-white shadow-glow">Filtrer</button>
            </form>

            <div class="mt-8 grid grid-cols-2 gap-2.5 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($products as $product)
                    <article class="group relative overflow-hidden rounded-xl border border-blue-100 bg-white shadow-md transition hover:-translate-y-1 hover:shadow-premium sm:rounded-2xl">
                        <div class="relative h-32 overflow-hidden bg-slate-50 sm:h-56">
                            @if($product->is_on_promotion)
                                <span class="absolute left-2 top-2 z-20 rounded-full bg-orange-400 px-2 py-1 text-[9px] font-black text-white shadow-premium sm:px-3 sm:text-xs">Promo</span>
                            @endif
                            <span class="absolute right-2 top-2 z-20 rounded-full bg-white px-2 py-1 text-[9px] font-black uppercase tracking-[0.08em] text-royal shadow-md sm:px-3 sm:text-xs">{{ ucfirst($product->type) }}</span>
                            <img src="{{ $product->imageUrl($product->type === 'formation' ? '/assets/training/crypto-masterclass.jpg' : '/assets/training/digital-products.jpg') }}" alt="{{ $product->title }}" class="absolute inset-0 h-full w-full object-contain p-2 transition duration-700 group-hover:scale-105 sm:p-4">
                        </div>

                        <div class="p-3 sm:p-5">
                            <h2 class="line-clamp-2 min-h-9 text-xs font-semibold leading-tight text-slate-800 sm:min-h-12 sm:text-base">{{ $product->title }}</h2>
                            <p class="mt-1 text-[9px] font-black uppercase tracking-[0.12em] text-emerald-600 sm:text-xs">{{ ucfirst($product->type) }}</p>
                            <p class="mt-1 line-clamp-2 text-[10px] font-semibold leading-4 text-slate-500 sm:mt-2 sm:text-xs sm:leading-5">{{ $product->description }}</p>
                        </div>

                        <div class="flex items-end justify-between gap-2 px-3 pb-3 sm:px-5 sm:pb-5">
                            <x-product-price :product="$product" />
                            <a href="{{ route('products.show', $product) }}" class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-royal text-white shadow-glow transition hover:bg-navy sm:h-10 sm:w-10" aria-label="Voir detail">
                                <x-icon name="shopping-cart" class="h-4 w-4 sm:h-5 sm:w-5" />
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl bg-white p-8 text-sm font-bold text-slate-500 shadow-premium sm:col-span-2 lg:col-span-3">Aucune offre ne correspond a votre recherche.</div>
                @endforelse
            </div>

            <div class="mt-8">{{ $products->links() }}</div>
        </div>
    </section>
@endsection
