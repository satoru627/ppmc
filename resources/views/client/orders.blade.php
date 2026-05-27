@extends('layouts.app')

@section('title', 'Mes commandes')
@section('nav_mode', 'dark')

@section('content')
    @php
        $paidAmount = number_format($orderStats['paid_amount'] ?? 0, 0, ',', ' ') . ' FCFA';
        $statCards = [
            ['Total commandes', $orderStats['total'] ?? 0, 'package', 'Toutes vos commandes'],
            ['Commandes payees', $orderStats['paid'] ?? 0, 'check-circle', 'Achats confirmes'],
            ['En attente', $orderStats['pending'] ?? 0, 'clock', 'Paiements a finaliser'],
            ['Montant confirme', $paidAmount, 'wallet', 'Total des achats payes'],
        ];
    @endphp

    <section class="relative -mt-24 overflow-hidden bg-navy px-4 pb-10 pt-32 text-white sm:px-6 sm:pb-14 lg:px-8">
        <div class="relative mx-auto grid max-w-7xl gap-6 md:grid-cols-[minmax(0,1fr)_21rem] md:items-end xl:grid-cols-[minmax(0,1fr)_24rem]">
            <div>
                <p class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-gold backdrop-blur">Historique client</p>
                <h1 class="mt-5 text-3xl font-black leading-tight sm:text-6xl">Mes commandes</h1>
                <p class="mt-4 max-w-2xl text-sm font-semibold leading-7 text-white/70">Suivez vos achats, telechargez vos contenus confirmes et recuperez vos factures PDF depuis le meme espace.</p>
            </div>

            <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-5 shadow-2xl backdrop-blur-2xl">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-white/55">Total paye</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $paidAmount }}</p>
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <a href="{{ route('service') }}" class="rounded-2xl bg-gold px-4 py-3 text-center text-xs font-black text-navy shadow-gold">Acheter</a>
                    <a href="{{ route('client.dashboard') }}" class="rounded-2xl border border-white/15 px-4 py-3 text-center text-xs font-black text-white">Dashboard</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-2 gap-3 md:grid-cols-4 lg:gap-5">
                @foreach($statCards as [$label, $value, $icon, $caption])
                    <article class="premium-card rounded-[1.25rem] p-4 transition hover:-translate-y-1 hover:shadow-premium md:min-h-[10.5rem] lg:rounded-[2rem] lg:p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-[0.14em] text-slate-400 sm:text-xs">{{ $label }}</p>
                                <p class="mt-3 break-words text-2xl font-black leading-tight text-navy lg:text-3xl">{{ $value }}</p>
                            </div>
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-2xl bg-royal/10 text-royal lg:h-10 lg:w-10">
                                <x-icon :name="$icon" class="h-4 w-4 lg:h-5 lg:w-5" />
                            </span>
                        </div>
                        <p class="mt-4 text-xs font-bold leading-5 text-slate-500">{{ $caption }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Achats</p>
                    <h2 class="mt-2 text-2xl font-black text-navy sm:text-4xl">Historique complet</h2>
                </div>
                <a href="{{ route('catalog') }}" class="inline-flex w-fit items-center gap-2 rounded-full bg-navy px-5 py-3 text-sm font-black text-white shadow-premium">
                    Voir le catalogue
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            <div class="mt-6 grid gap-4">
                @forelse($orders as $order)
                    @php
                        $statusMeta = match ($order->status) {
                            \App\Models\Order::STATUS_PAID => ['Payee', 'bg-emerald-50 text-emerald-700 ring-emerald-100', 'check-circle'],
                            \App\Models\Order::STATUS_PENDING => ['En attente', 'bg-gold/20 text-[#805B08] ring-gold/30', 'clock'],
                            \App\Models\Order::STATUS_FAILED => ['Echec', 'bg-red-50 text-red-700 ring-red-100', 'shield'],
                            \App\Models\Order::STATUS_CANCELED => ['Annulee', 'bg-slate-100 text-slate-600 ring-slate-200', 'shield'],
                            default => [ucfirst($order->status), 'bg-slate-100 text-slate-600 ring-slate-200', 'package'],
                        };
                        $product = $order->product;
                        $downloadUrl = null;

                        if ($order->isPaid() && $product?->file_path) {
                            $downloadUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                                'client.download',
                                now()->addHours(48),
                                ['token' => \Illuminate\Support\Facades\Crypt::encryptString((string) $order->id)]
                            );
                        }
                    @endphp

                    <article class="premium-card overflow-hidden rounded-[1.5rem] sm:rounded-[2rem]">
                        <div class="grid gap-0 md:grid-cols-[minmax(0,1fr)_17rem] xl:grid-cols-[minmax(0,1fr)_19rem]">
                            <div class="p-4 sm:p-6">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] ring-1 {{ $statusMeta[1] }}">
                                        <x-icon :name="$statusMeta[2]" class="h-3.5 w-3.5" />
                                        {{ $statusMeta[0] }}
                                    </span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-[10px] font-black text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    @if($product)
                                        <span class="rounded-full bg-royal/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] text-royal">{{ $product->type }}</span>
                                    @endif
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-end md:grid-cols-1 xl:grid-cols-[minmax(0,1fr)_auto]">
                                    <div class="min-w-0">
                                        <h3 class="line-clamp-2 text-xl font-black leading-tight text-navy xl:text-2xl">{{ $product?->title ?? 'Produit indisponible' }}</h3>
                                        <p class="mt-2 text-sm font-semibold leading-6 text-slate-500">Commande #{{ $order->id }} @if($order->payment_reference) <span class="text-slate-400">- Reference {{ $order->payment_reference }}</span> @endif</p>
                                    </div>
                                    <p class="text-2xl font-black text-royal sm:text-right md:text-left xl:text-right">{{ $order->formatted_amount }}</p>
                                </div>
                            </div>

                            <div class="border-t border-slate-200 bg-slate-50 p-4 sm:p-5 md:border-l md:border-t-0">
                                @if($order->isPaid())
                                    <p class="text-xs font-black uppercase tracking-[0.14em] text-slate-400">Actions disponibles</p>
                                    <div class="mt-4 grid gap-2">
                                        @if($downloadUrl)
                                            <a href="{{ $downloadUrl }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-royal px-4 py-3 text-sm font-black text-white shadow-glow">
                                                Telecharger
                                                <x-icon name="arrow-right" class="h-4 w-4" />
                                            </a>
                                        @endif
                                        <a href="{{ route('client.orders.invoice', $order) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-navy px-4 py-3 text-sm font-black text-white shadow-premium">
                                            Facture PDF
                                            <x-icon name="arrow-right" class="h-4 w-4" />
                                        </a>
                                    </div>
                                    <p class="mt-3 text-xs font-bold leading-5 text-slate-500">Les liens de telechargement sont signes et limites dans le temps.</p>
                                @elseif($order->status === \App\Models\Order::STATUS_PENDING)
                                    <p class="text-sm font-black text-navy">Paiement en attente</p>
                                    <p class="mt-2 text-xs font-bold leading-5 text-slate-500">La commande sera debloquee apres confirmation du paiement.</p>
                                    <a href="{{ route('client.support') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-black text-navy">
                                        Contacter le support
                                        <x-icon name="arrow-right" class="h-4 w-4" />
                                    </a>
                                @else
                                    <p class="text-sm font-black text-navy">Commande non finalisee</p>
                                    <p class="mt-2 text-xs font-bold leading-5 text-slate-500">Vous pouvez reprendre votre achat depuis le catalogue si necessaire.</p>
                                    <a href="{{ route('catalog') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-black text-navy ring-1 ring-slate-200">
                                        Retour au catalogue
                                        <x-icon name="arrow-right" class="h-4 w-4" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="premium-card rounded-[2rem] p-8 text-center">
                        <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-royal/10 text-royal">
                            <x-icon name="package" class="h-7 w-7" />
                        </div>
                        <h3 class="mt-5 text-2xl font-black text-navy">Aucune commande</h3>
                        <p class="mx-auto mt-3 max-w-md text-sm font-semibold leading-7 text-slate-500">Explorez les formations et services disponibles pour demarrer votre premier achat.</p>
                        <a href="{{ route('catalog') }}" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-navy px-6 py-3 text-sm font-black text-white shadow-premium">
                            Voir le catalogue
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                @endforelse
            </div>

            @if($orders->hasPages())
                <div class="mt-8 rounded-[1.5rem] bg-white p-4 shadow-premium">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
