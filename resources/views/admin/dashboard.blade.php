@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@section('content')
    @php
        $kpis = [
            ['CA total', number_format($stats['revenue'], 0, ',', ' ') . ' FCFA', 'Revenus confirmes', 'bg-emerald-500/15 text-emerald-600', 'trending-up'],
            ['Ventes', $stats['sales'], 'Commandes payees', 'bg-royal/10 text-royal', 'check-circle'],
            ['En attente', $stats['pending_orders'], 'A verifier', 'bg-gold/20 text-[#805B08]', 'clock'],
            ['Produits', $stats['products'], 'Offres configurees', 'bg-slate-100 text-navy', 'package'],
            ['Clients', $stats['clients'], 'Comptes clients', 'bg-violet-100 text-violet-700', 'users'],
            ['Support', $stats['open_tickets'], 'Tickets ouverts', 'bg-rose-100 text-rose-700', 'shield'],
        ];
    @endphp

    <section class="relative overflow-hidden rounded-[1.5rem] bg-navy p-4 text-white shadow-premium sm:rounded-[2.25rem] sm:p-8">
        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-gold/10 blur-3xl sm:h-64 sm:w-64"></div>

        <div class="relative grid gap-5 lg:grid-cols-[1fr_auto] lg:items-end">
            <div>
                <p class="inline-flex rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-gold backdrop-blur sm:px-4 sm:py-2 sm:text-xs sm:tracking-[0.18em]">Admin intelligence</p>
                <h2 class="mt-4 max-w-3xl text-2xl font-black leading-tight sm:mt-5 sm:text-5xl">Pilotage commercial de la plateforme.</h2>
                <p class="mt-3 max-w-2xl text-xs font-semibold leading-6 text-white/60 sm:mt-4 sm:text-sm sm:leading-7">Surveillez les ventes, les paiements, les produits et les clients depuis un tableau de bord operationnel.</p>
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-3">
                <a href="{{ route('admin.products.create') }}" class="rounded-2xl border border-white/10 bg-white/10 p-3 text-center text-[11px] font-black leading-4 text-white backdrop-blur transition hover:bg-white/15 sm:rounded-3xl sm:p-4 sm:text-xs">Ajouter<br>produit</a>
                <a href="{{ route('admin.orders.chariow.create') }}" class="rounded-2xl border border-white/10 bg-white/10 p-3 text-center text-[11px] font-black leading-4 text-white backdrop-blur transition hover:bg-white/15 sm:rounded-3xl sm:p-4 sm:text-xs">Vente<br>Chariow</a>
                <a href="{{ route('admin.stats') }}" class="rounded-2xl border border-white/10 bg-white/10 p-3 text-center text-[11px] font-black leading-4 text-white backdrop-blur transition hover:bg-white/15 sm:rounded-3xl sm:p-4 sm:text-xs">Stats<br>avancees</a>
            </div>
        </div>
    </section>

    <section class="mt-4 grid grid-cols-2 gap-3 sm:mt-6 sm:gap-4 md:grid-cols-3 xl:grid-cols-6">
        @foreach($kpis as [$label, $value, $hint, $tone, $icon])
            <article class="premium-card rounded-[1.25rem] p-3 transition hover:-translate-y-1 hover:shadow-premium sm:rounded-[2rem] sm:p-5 {{ $loop->last ? 'col-span-2 md:col-span-1' : '' }}">
                <div class="flex items-start justify-between gap-2 sm:gap-4">
                    <div class="min-w-0">
                        <p class="truncate text-[10px] font-black uppercase tracking-[0.12em] text-slate-400 sm:text-xs sm:tracking-[0.14em]">{{ $label }}</p>
                        <p class="mt-2 truncate text-lg font-black text-navy sm:mt-3 sm:text-2xl">{{ $value }}</p>
                    </div>
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-2xl sm:h-11 sm:w-11 {{ $tone }}"><x-icon :name="$icon" class="h-4 w-4 sm:h-5 sm:w-5" /></span>
                </div>
                <p class="mt-3 truncate text-[11px] font-bold text-slate-500 sm:mt-4 sm:text-xs">{{ $hint }}</p>
                <div class="mt-3 h-1 overflow-hidden rounded-full bg-slate-100 sm:mt-4 sm:h-1.5">
                    <div class="h-full rounded-full bg-gradient-to-r from-royal to-gold" style="width: {{ $loop->index === 0 ? '92' : (82 - ($loop->index * 9)) }}%"></div>
                </div>
            </article>
        @endforeach
    </section>

    <section class="mt-5 grid gap-4 sm:mt-8 sm:gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="premium-card overflow-hidden rounded-[1.5rem] sm:rounded-[2rem]">
            <div class="flex items-center justify-between gap-3 border-b border-slate-100 p-4 sm:p-6">
                <div class="min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-[0.14em] text-royal sm:text-sm sm:tracking-[0.18em]">Flux commandes</p>
                    <h2 class="mt-1 truncate text-xl font-black text-navy sm:text-2xl">Dernieres commandes</h2>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="shrink-0 rounded-full bg-navy px-4 py-2.5 text-xs font-black text-white shadow-premium sm:px-5 sm:py-3 sm:text-sm">Gerer</a>
            </div>

            <div class="grid gap-3 p-3 md:hidden">
                @forelse($latestOrders->take(4) as $order)
                    @php
                        $statusClass = match($order->status) {
                            'paid' => 'bg-emerald-100 text-emerald-700',
                            'pending' => 'bg-gold/20 text-[#805B08]',
                            'failed', 'canceled' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-600',
                        };
                    @endphp
                    <article class="rounded-2xl bg-slate-50 p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-black text-navy">{{ optional($order->user)->name ?? 'Client supprime' }}</p>
                                <p class="mt-1 truncate text-[11px] font-bold text-slate-400">{{ optional($order->product)->title ?? 'Produit supprime' }}</p>
                            </div>
                            <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-black {{ $statusClass }}">{{ $order->status }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between gap-3">
                            <p class="text-xs font-black text-navy">{{ $order->formatted_amount }}</p>
                            <p class="text-[10px] font-bold text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </article>
                @empty
                    <p class="px-3 py-6 text-center text-sm font-bold text-slate-500">Aucune commande.</p>
                @endforelse
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="w-full min-w-[820px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-black uppercase tracking-[0.14em] text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Produit</th>
                            <th class="px-6 py-4">Montant</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($latestOrders as $order)
                            @php
                                $statusClass = match($order->status) {
                                    'paid' => 'bg-emerald-100 text-emerald-700',
                                    'pending' => 'bg-gold/20 text-[#805B08]',
                                    'failed', 'canceled' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-5">
                                    <p class="font-black text-navy">{{ optional($order->user)->name ?? 'Client supprime' }}</p>
                                    <p class="mt-1 text-xs font-bold text-slate-400">{{ optional($order->user)->email }}</p>
                                </td>
                                <td class="px-6 py-5 font-bold text-slate-600">{{ optional($order->product)->title ?? 'Produit supprime' }}</td>
                                <td class="px-6 py-5 font-black text-navy">{{ $order->formatted_amount }}</td>
                                <td class="px-6 py-5"><span class="rounded-full px-3 py-1 text-xs font-black {{ $statusClass }}">{{ $order->status }}</span></td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-10 text-center text-sm font-bold text-slate-500">Aucune commande.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid gap-4 sm:gap-6">
            <section class="rounded-[1.5rem] bg-navy p-4 text-white shadow-premium sm:rounded-[2rem] sm:p-6">
                <p class="text-[10px] font-black uppercase tracking-[0.14em] text-gold sm:text-sm sm:tracking-[0.18em]">Produits populaires</p>
                <div class="mt-4 grid gap-2 sm:mt-5 sm:gap-3">
                    @forelse($popularProducts as $product)
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-3 backdrop-blur sm:rounded-3xl sm:p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="line-clamp-2 text-sm font-black sm:text-base">{{ $product->title }}</p>
                                <span class="shrink-0 rounded-full bg-gold px-2.5 py-1 text-[10px] font-black text-navy sm:px-3 sm:text-xs">{{ $product->paid_orders_count }}</span>
                            </div>
                            <p class="mt-1 text-[11px] font-bold text-white/50 sm:mt-2 sm:text-xs">vente(s) payee(s)</p>
                        </div>
                    @empty
                        <p class="text-sm font-bold text-white/50">Aucune vente confirmee.</p>
                    @endforelse
                </div>
            </section>

            <section class="premium-card rounded-[1.5rem] p-4 sm:rounded-[2rem] sm:p-6">
                <p class="text-[10px] font-black uppercase tracking-[0.14em] text-royal sm:text-sm sm:tracking-[0.18em]">Priorites</p>
                <div class="mt-4 grid grid-cols-1 gap-2 sm:mt-5 sm:gap-3">
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="rounded-2xl bg-mist p-3 text-xs font-black text-navy transition hover:bg-slate-100 sm:rounded-3xl sm:p-4 sm:text-sm">Verifier les paiements en attente</a>
                    <a href="{{ route('admin.orders.chariow.create') }}" class="rounded-2xl bg-mist p-3 text-xs font-black text-navy transition hover:bg-slate-100 sm:rounded-3xl sm:p-4 sm:text-sm">Ajouter une vente Chariow</a>
                    <a href="{{ route('admin.support.index', ['status' => 'open']) }}" class="rounded-2xl bg-mist p-3 text-xs font-black text-navy transition hover:bg-slate-100 sm:rounded-3xl sm:p-4 sm:text-sm">Traiter les tickets support</a>
                    <a href="{{ route('admin.products.index') }}" class="rounded-2xl bg-mist p-3 text-xs font-black text-navy transition hover:bg-slate-100 sm:rounded-3xl sm:p-4 sm:text-sm">Mettre a jour le catalogue</a>
                    <a href="{{ route('admin.users.index') }}" class="rounded-2xl bg-mist p-3 text-xs font-black text-navy transition hover:bg-slate-100 sm:rounded-3xl sm:p-4 sm:text-sm">Controler les comptes clients</a>
                </div>
            </section>
        </div>
    </section>
@endsection
