@extends('layouts.app')

@section('title', 'Support client')
@section('nav_mode', 'dark')

@section('content')
    @php
        $openTickets = $tickets->getCollection()->where('status', 'open')->count();
        $recentTicket = $tickets->getCollection()->first();
    @endphp

    <section class="relative -mt-24 overflow-hidden bg-navy px-4 pb-10 pt-32 text-white sm:px-6 sm:pb-14 lg:px-8">
        <div class="relative mx-auto grid max-w-7xl gap-6 md:grid-cols-[minmax(0,1fr)_22rem] md:items-end">
            <div>
                <p class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-gold backdrop-blur">Assistance client</p>
                <h1 class="mt-5 text-3xl font-black leading-tight sm:text-6xl">Contacter l'equipe</h1>
                <p class="mt-4 max-w-2xl text-sm font-semibold leading-7 text-white/70">Une demande claire pour vos commandes, telechargements, factures et transferts accompagnes.</p>
            </div>

            <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-5 shadow-2xl backdrop-blur-2xl">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-white/55">Tickets affiches</p>
                <p class="mt-2 text-3xl font-black text-white">{{ $tickets->total() }}</p>
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <div class="rounded-2xl bg-white/10 px-4 py-3">
                        <p class="text-[10px] font-black uppercase tracking-[0.12em] text-white/45">Ouverts</p>
                        <p class="mt-1 text-xl font-black text-gold">{{ $openTickets }}</p>
                    </div>
                    <a href="{{ route('client.orders') }}" class="rounded-2xl border border-white/15 px-4 py-3 text-center text-xs font-black text-white">Commandes</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <aside class="grid gap-5 md:grid-cols-2 xl:grid-cols-1">
                <form method="POST" action="{{ route('client.support.store') }}" class="premium-card rounded-[1.75rem] p-5 sm:rounded-[2rem] sm:p-6" data-loading-form>
                    @csrf
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Nouveau ticket</p>
                            <h2 class="mt-2 text-2xl font-black text-navy">Expliquez le besoin</h2>
                        </div>
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-royal/10 text-royal">
                            <x-icon name="shield" class="h-5 w-5" />
                        </span>
                    </div>

                    <div class="mt-6 grid gap-5">
                        <label class="grid gap-2 text-sm font-black text-navy">
                            Sujet
                            <input name="subject" value="{{ old('subject') }}" required class="rounded-2xl border border-slate-200 bg-mist px-4 py-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white" placeholder="Ex: Probleme de facture">
                        </label>
                        <label class="grid gap-2 text-sm font-black text-navy">
                            Message
                            <textarea name="message" rows="6" required class="resize-none rounded-2xl border border-slate-200 bg-mist px-4 py-4 text-sm font-semibold leading-7 outline-none transition focus:border-royal focus:bg-white" placeholder="Donnez le maximum de details utiles">{{ old('message') }}</textarea>
                        </label>
                        <button class="inline-flex items-center justify-center gap-2 rounded-full bg-royal px-6 py-4 text-sm font-black text-white shadow-glow transition hover:-translate-y-1 hover:bg-navy" data-loading-submit>
                            Envoyer la demande
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </button>
                    </div>
                </form>

                <section class="rounded-[1.75rem] bg-navy p-5 text-white shadow-premium sm:rounded-[2rem] sm:p-6">
                    <p class="text-sm font-black uppercase tracking-[0.18em] text-gold">Avant d'envoyer</p>
                    <div class="mt-5 grid gap-3">
                        @foreach([
                            ['Commande', 'Ajoutez le numero si votre demande concerne un achat.'],
                            ['Paiement', 'Precisez la reference de commande ou de transaction.'],
                            ['Livraison', 'Indiquez le produit et l email du compte.'],
                        ] as [$title, $text])
                            <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                                <p class="text-sm font-black">{{ $title }}</p>
                                <p class="mt-1 text-xs font-semibold leading-5 text-white/60">{{ $text }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>

            <section class="premium-card rounded-[1.75rem] p-5 sm:rounded-[2rem] sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Historique</p>
                        <h2 class="mt-2 text-2xl font-black text-navy sm:text-3xl">Mes tickets</h2>
                    </div>
                    @if($recentTicket)
                        <span class="w-fit rounded-full bg-slate-100 px-4 py-2 text-xs font-black text-slate-500">Dernier: {{ $recentTicket->created_at->format('d/m/Y') }}</span>
                    @endif
                </div>

                <div class="mt-6 grid gap-4">
                    @forelse($tickets as $ticket)
                        @php
                            $ticketStatus = match ($ticket->status) {
                                'closed' => ['Ferme', 'bg-emerald-50 text-emerald-700'],
                                'in_progress' => ['En traitement', 'bg-gold/20 text-[#805B08]'],
                                default => ['Ouvert', 'bg-royal/10 text-royal'],
                            };
                        @endphp

                        <article class="rounded-[1.5rem] border border-slate-200 bg-white p-4 sm:p-5">
                            <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_auto] md:items-start">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-[0.12em] {{ $ticketStatus[1] }}">{{ $ticketStatus[0] }}</span>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black text-slate-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <h3 class="mt-3 text-lg font-black leading-tight text-navy">{{ $ticket->subject }}</h3>
                                    <p class="mt-2 line-clamp-3 text-sm font-semibold leading-7 text-slate-500">{{ $ticket->message }}</p>
                                </div>
                                <a href="{{ route('client.support') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 px-4 py-2.5 text-xs font-black text-navy transition hover:border-royal hover:text-royal">
                                    Suivre
                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[1.5rem] bg-mist p-8 text-center">
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-royal/10 text-royal">
                                <x-icon name="shield" class="h-7 w-7" />
                            </div>
                            <h3 class="mt-4 text-xl font-black text-navy">Aucun ticket ouvert</h3>
                            <p class="mx-auto mt-2 max-w-md text-sm font-semibold leading-7 text-slate-500">Envoyez une demande si vous avez besoin d'aide sur un achat, une facture ou une livraison.</p>
                        </div>
                    @endforelse
                </div>

                @if($tickets->hasPages())
                    <div class="mt-6 rounded-[1.5rem] bg-white p-4 shadow-soft">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </section>
        </div>
    </section>
@endsection
