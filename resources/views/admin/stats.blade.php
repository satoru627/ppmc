@extends('layouts.admin')

@section('title', 'Statistiques')
@section('page_title', 'Statistiques')

@section('content')
    {{-- Statistiques commerciales --}}
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['CA total', number_format($stats['revenue'], 0, ',', ' ') . ' FCFA'],
            ['Ventes payees', $stats['sales']],
            ['Commandes en attente', $stats['pending_orders']],
            ['Clients', $stats['clients']],
        ] as [$label, $value])
            <div class="rounded-3xl bg-white p-6 shadow-soft">
                <p class="text-xs font-black uppercase tracking-[0.14em] text-slate-400">{{ $label }}</p>
                <p class="mt-3 text-3xl font-black text-royal">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section class="rounded-[2rem] bg-white p-6 shadow-soft">
            <h2 class="text-xl font-black">CA mensuel</h2>
            <div class="mt-5 grid gap-3">
                @forelse($monthlyRevenue as $row)
                    <div class="flex items-center justify-between rounded-3xl bg-mist p-4">
                        <span class="font-black">{{ $row->month }}</span>
                        <span class="text-sm font-bold text-slate-500">{{ $row->sales }} vente(s)</span>
                        <span class="font-black text-royal">{{ number_format($row->revenue, 0, ',', ' ') }} FCFA</span>
                    </div>
                @empty
                    <p class="text-sm font-bold text-slate-500">Aucune donnee payee.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-[2rem] bg-white p-6 shadow-soft">
            <h2 class="text-xl font-black">Produits populaires</h2>
            <div class="mt-5 grid gap-3">
                @forelse($popularProducts as $product)
                    <div class="flex items-center justify-between rounded-3xl border border-slate-200 p-4">
                        <span class="font-black">{{ $product->title }}</span>
                        <span class="text-sm font-black text-royal">{{ $product->paid_orders_count }} vente(s)</span>
                    </div>
                @empty
                    <p class="text-sm font-bold text-slate-500">Aucune vente confirmee.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
