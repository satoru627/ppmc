@extends('layouts.app')

@section('title', 'Dashboard client - ' . config('app.name', '[NOM_DU_SITE]'))
@section('nav_mode', 'dark')

@section('content')
    @php
        $statCards = [
            ['Achats payes', $stats['paid_orders'], 'check-circle', 'Commandes confirmees'],
            ['En attente', $stats['pending_orders'], 'clock', 'Paiements a finaliser'],
            ['Total achats', $stats['total_orders'], 'package', 'Toutes vos commandes'],
            ['Support', $stats['support_tickets'], 'shield', 'Tickets ouverts'],
        ];
        $paidAmount = number_format($stats['paid_amount'], 0, ',', ' ') . ' FCFA';
    @endphp

    <section class="relative -mt-24 overflow-hidden bg-navy px-4 pb-10 pt-32 text-white sm:px-6 sm:pb-16 lg:px-8">
        <div class="relative mx-auto grid max-w-7xl gap-6 md:grid-cols-[minmax(0,1fr)_21rem] md:items-end xl:grid-cols-[minmax(0,1fr)_24rem]">
            <div>
                <p class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-gold backdrop-blur">Espace client</p>
                <h1 class="mt-5 text-3xl font-black leading-tight sm:text-6xl">Bonjour {{ auth()->user()->name }}</h1>
                <p class="mt-4 max-w-2xl text-sm font-semibold leading-7 text-white/65">Retrouvez vos achats, factures et demandes support dans un espace simple et organise.</p>
            </div>

            <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-5 shadow-2xl backdrop-blur-2xl">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-white/50">Total confirme</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $paidAmount }}</p>
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <a href="{{ route('catalog') }}" class="rounded-2xl bg-gold px-4 py-3 text-center text-xs font-black text-navy shadow-gold">Acheter</a>
                    <a href="{{ route('client.orders') }}" class="rounded-2xl border border-white/15 px-4 py-3 text-center text-xs font-black text-white">Commandes</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-2 gap-3 md:grid-cols-4 lg:gap-5">
                @foreach($statCards as [$label, $value, $icon, $caption])
                    <div class="premium-card rounded-[1.35rem] p-4 transition hover:-translate-y-1 hover:shadow-premium sm:rounded-[2rem] sm:p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400 sm:text-xs">{{ $label }}</p>
                                <p class="mt-3 text-3xl font-black text-navy sm:text-4xl">{{ $value }}</p>
                            </div>
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-royal/10 text-royal"><x-icon :name="$icon" class="h-5 w-5" /></span>
                        </div>
                        <p class="mt-4 text-xs font-bold leading-5 text-slate-500">{{ $caption }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[minmax(0,1fr)_23rem]">
                <section class="premium-card rounded-[1.75rem] p-5 sm:rounded-[2rem] sm:p-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Historique</p>
                            <h2 class="mt-2 text-2xl font-black text-navy sm:text-3xl">Commandes recentes</h2>
                        </div>
                        <a href="{{ route('client.orders') }}" class="w-fit rounded-full bg-navy px-5 py-3 text-xs font-black text-white shadow-premium sm:text-sm">Tout voir</a>
                    </div>

                    <div class="mt-6 grid gap-3">
                        @forelse($recentOrders as $order)
                            @php
                                $statusStyle = match ($order->status) {
                                    \App\Models\Order::STATUS_PAID => 'bg-emerald-50 text-emerald-700',
                                    \App\Models\Order::STATUS_PENDING => 'bg-gold/20 text-[#805B08]',
                                    \App\Models\Order::STATUS_FAILED, \App\Models\Order::STATUS_CANCELED => 'bg-red-50 text-red-700',
                                    default => 'bg-slate-100 text-slate-500',
                                };
                            @endphp
                            <article class="rounded-[1.35rem] border border-slate-200 bg-white p-4 sm:rounded-3xl">
                                <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_auto] md:items-center">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-[0.12em] {{ $statusStyle }}">{{ $order->status }}</span>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black text-slate-500">{{ $order->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <h3 class="mt-3 truncate text-base font-black text-navy sm:text-lg">{{ $order->product->title }}</h3>
                                        <p class="mt-1 text-sm font-black text-royal">{{ $order->formatted_amount }}</p>
                                    </div>

                                    <div class="flex flex-col gap-2 sm:flex-row md:justify-end">
                                        @if($order->isPaid())
                                            <a href="{{ route('client.orders.invoice', $order) }}" class="rounded-full bg-navy px-4 py-2.5 text-center text-xs font-black text-white shadow-premium">Facture</a>
                                        @else
                                            <span class="rounded-full bg-slate-100 px-4 py-2.5 text-center text-xs font-black text-slate-500">En attente</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-[1.5rem] bg-mist p-6 text-sm font-bold leading-7 text-slate-500">
                                Aucune commande pour le moment. Explorez le catalogue pour demarrer.
                            </div>
                        @endforelse
                    </div>
                </section>

                <aside class="grid gap-5">
                    <section class="rounded-[1.75rem] bg-navy p-5 text-white shadow-premium sm:rounded-[2rem] sm:p-6">
                        <p class="text-sm font-black uppercase tracking-[0.18em] text-gold">Actions rapides</p>
                        <div class="mt-5 grid gap-3">
                            <a href="{{ route('training') }}" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/10 px-5 py-4 text-sm font-black transition hover:bg-white/15">
                                Formations
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('service') }}" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/10 px-5 py-4 text-sm font-black transition hover:bg-white/15">
                                Services
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('client.support') }}" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/10 px-5 py-4 text-sm font-black transition hover:bg-white/15">
                                Support
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        </div>
                    </section>

                    <section class="premium-card rounded-[1.75rem] p-5 sm:rounded-[2rem] sm:p-6">
                        <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Aide</p>
                        <h3 class="mt-3 text-xl font-black text-navy">Besoin d assistance ?</h3>
                        <p class="mt-3 text-sm font-semibold leading-7 text-slate-500">Notre support peut vous aider pour les paiements, factures, acces et transferts.</p>
                        <a href="{{ route('client.support') }}" class="mt-5 block rounded-full bg-royal px-5 py-3 text-center text-sm font-black text-white shadow-glow">Ouvrir un ticket</a>
                    </section>
                </aside>
            </div>
        </div>
    </section>
@endsection
