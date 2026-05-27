@extends('layouts.app')

@section('title', 'Catalogue - ' . config('app.name', '[NOM_DU_SITE]'))
@section('nav_mode', 'dark')

@section('content')
    <section class="relative -mt-24 overflow-hidden px-4 pb-12 pt-32 sm:px-6 sm:pb-20 sm:pt-36 lg:px-8 lg:pb-28">
        <div class="absolute inset-0 overflow-hidden bg-navy">
            <div class="absolute inset-0 opacity-[0.05]" style="background-image:linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:50px 50px"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-[1.2fr_0.8fr] items-center gap-4 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
            <div class="z-10 text-white">
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.15em] text-gold backdrop-blur-md sm:mb-8 sm:px-4 sm:py-2 sm:text-xs">
                    <span class="relative flex h-1.5 w-1.5 sm:h-2 sm:w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold opacity-75"></span><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-gold sm:h-2 sm:w-2"></span></span>
                    Catalogue Premium
                </p>
                <h1 class="max-w-4xl text-3xl font-black leading-tight tracking-tight sm:text-6xl xl:text-[80px]">
                    Toutes nos <br>
                    <span class="bg-gradient-to-r from-white via-white to-gold bg-clip-text text-transparent">Offres Digitales</span>
                </h1>
                <p class="mt-4 max-w-xl text-xs font-medium leading-relaxed text-white/60 sm:mt-8 sm:text-xl">
                    Formations, services, actifs digitaux et accompagnement premium. Payez en FCFA via Mobile Money.
                </p>
                <div class="mt-6 flex flex-col gap-2 sm:mt-12 sm:flex-row sm:items-center sm:gap-6">
                    <a href="{{ route('catalog', ['type' => 'formation']) }}" class="rounded-full bg-gold px-6 py-3 text-center text-xs font-black text-navy shadow-gold transition hover:scale-105 sm:px-10 sm:py-5 sm:text-sm">Formations</a>
                    <a href="{{ route('catalog', ['type' => 'service']) }}" class="rounded-full border border-white/20 bg-white/5 px-6 py-3 text-center text-xs font-black text-white backdrop-blur-md sm:px-10 sm:py-5 sm:text-sm">Services</a>
                </div>
            </div>

            <div class="relative perspective-1000">
                <div class="relative z-10 overflow-hidden rounded-3xl border border-white/10 bg-navy/40 p-3 shadow-2xl backdrop-blur-2xl animate-float md:p-5 xl:rounded-[2.5rem] xl:bg-white/[0.03] xl:p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2"><span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-400"></span><p class="text-[10px] font-black uppercase tracking-[0.15em] text-white/60">Live catalogue</p></div>
                            <h2 class="mt-2 text-2xl font-black text-white sm:text-3xl">{{ $products->total() }} offres</h2>
                        </div>
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-royal to-navy text-gold shadow-lg"><x-icon name="grid" class="h-6 w-6" /></div>
                    </div>
                    <div class="grid gap-4">
                        @foreach([['Formations', 'Modules premium', '82%'], ['Services', 'Actifs verifies', '68%'], ['Support', 'Livraison email + PDF', '91%']] as [$label, $value, $width])
                            <div class="rounded-3xl border border-white/5 bg-white/[0.05] p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div><p class="font-black text-white">{{ $label }}</p><p class="text-xs font-bold text-white/60">{{ $value }}</p></div>
                                    <span class="rounded-full bg-gold/20 px-3 py-1 text-xs font-black text-gold">Actif</span>
                                </div>
                                <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-white/10"><div class="h-full rounded-full bg-gradient-to-r from-royal via-royal to-gold" style="width: {{ $width }}"></div></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <form method="GET" action="{{ route('catalog') }}" class="-mt-20 relative z-20 grid gap-3 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-premium md:grid-cols-[1fr_220px_auto]">
                <input name="search" value="{{ request('search') }}" class="h-12 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none focus:border-royal focus:bg-white" placeholder="Rechercher une formation ou un service">
                <select name="type" class="h-12 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-bold outline-none focus:border-royal focus:bg-white">
                    <option value="">Tous les types</option>
                    <option value="formation" @selected(request('type') === 'formation')>Formations</option>
                    <option value="service" @selected(request('type') === 'service')>Services</option>
                </select>
                <button class="h-12 rounded-2xl bg-royal px-6 text-sm font-black text-white shadow-glow">Filtrer</button>
            </form>

            <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($products as $product)
                    <article class="overflow-hidden rounded-[1.5rem] bg-white shadow-premium transition hover:-translate-y-2 sm:rounded-[2rem]">
                        <div class="relative h-36 bg-slate-100 sm:h-56">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/assets/training/digital-products.jpg') }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/70 via-transparent to-transparent"></div>
                            <span class="absolute left-3 top-3 rounded-full bg-white px-2.5 py-1 text-[10px] font-black text-royal sm:left-4 sm:top-4 sm:px-3 sm:text-xs">{{ ucfirst($product->type) }}</span>
                        </div>
                        <div class="p-4 sm:p-6">
                            <h2 class="min-h-10 text-sm font-black leading-tight text-navy sm:text-lg">{{ $product->title }}</h2>
                            <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500 sm:mt-3 sm:text-sm sm:leading-7">{{ $product->description }}</p>
                            <div class="mt-4 flex flex-col gap-2 sm:mt-6 sm:flex-row sm:items-center sm:justify-between sm:gap-3">
                                <span class="text-xs font-black text-navy sm:text-lg">{{ $product->formatted_price }}</span>
                                <a href="{{ route('products.show', $product) }}" class="rounded-full bg-navy px-4 py-2 text-center text-xs font-black text-white shadow-premium sm:px-5 sm:py-2.5 sm:text-sm">Details</a>
                            </div>
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
