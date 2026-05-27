@extends('layouts.app')

@section('title', 'PPMC - Accueil')
@section('hide_layout_shell', 'true')

@section('content')
    @php
        $socials = [
            ['tiktok', 'TikTok'],
            ['instagram', 'Instagram'],
            ['youtube', 'YouTube'],
            ['facebook', 'Facebook'],
            ['twitter', 'X'],
            ['linkedin', 'LinkedIn'],
            ['pinterest', 'Pinterest'],
            ['snapchat', 'Snapchat'],
        ];

        $benefits = [
            ['shield', 'Paiement securise'],
            ['trending-up', 'Acces instantane'],
            ['clock', 'Mises a jour regulieres'],
            ['users', 'Support 24/7'],
        ];

        $features = [
            ['shield', 'Fiable & Securise', 'Transactions securisees et comptes 100% verifies.'],
            ['trending-up', 'Acces Instantane', 'Accedez immediatement a vos formations et comptes.'],
            ['check-circle', 'Qualite Premium', 'Contenus et comptes de haute qualite selectionnes.'],
            ['users', 'Support Dedie', 'Une equipe disponible 24/7 pour vous accompagner.'],
        ];

        $testimonials = [
            ['Thomas D.', 'Entrepreneur', 'Grace aux formations, j ai pu monetiser mon TikTok et generer mes premiers revenus en deux mois.', 'https://images.pexels.com/photos/34592823/pexels-photo-34592823.jpeg?auto=compress&cs=tinysrgb&w=160&h=160&fit=crop'],
            ['Sarah B.', 'Creatrice de contenu', 'J ai achete un compte Instagram deja monetise et je genere des revenus des le premier jour. Service au top.', 'https://images.pexels.com/photos/19057377/pexels-photo-19057377.jpeg?auto=compress&cs=tinysrgb&w=160&h=160&fit=crop'],
            ['Lucas G.', 'Digital Marketer', 'La meilleure plateforme pour se lancer serieusement dans la monetisation des reseaux sociaux.', 'https://images.pexels.com/photos/33844626/pexels-photo-33844626.jpeg?auto=compress&cs=tinysrgb&w=160&h=160&fit=crop'],
            ['Kevin M.', 'Freelance', 'Le paiement est simple et la livraison rapide. J ai recu mes acces et ma facture sans complication.', 'https://images.pexels.com/photos/9363150/pexels-photo-9363150.jpeg?auto=compress&cs=tinysrgb&w=160&h=160&fit=crop'],
        ];

        $deviceImages = [
            'laptop' => 'https://upload.wikimedia.org/wikipedia/commons/8/8d/MacBook_Pro_transparency.png',
            'phone' => '/assets/devices/telephone.jpg',
        ];
    @endphp

    <div class="min-h-screen bg-white text-[#071B3B]">
        <section class="relative overflow-hidden bg-[#000080] bg-cover bg-center text-white" style="background-image: url('{{ asset('/assets/hero-background.jpg') }}')">
            <div class="absolute inset-x-0 bottom-0 h-px bg-white/10"></div>

            <header class="fixed inset-x-0 top-0 z-50 px-3 pt-3 sm:px-6 sm:pt-4 lg:px-8">
                <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-3 rounded-[1.25rem] border border-white/15 bg-white/[0.10] px-3 shadow-[0_24px_80px_rgba(0,0,0,0.24)] backdrop-blur-2xl transition-all duration-300 sm:h-20 sm:rounded-[1.75rem] sm:px-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('/assets/logo.png') }}" alt="PPMC" class="h-10 w-auto max-w-[4.75rem] rounded-xl object-contain sm:h-11 sm:max-w-[5.25rem]">
                        <span class="text-xl font-black tracking-normal">PPMC</span>
                    </a>

                    <nav class="hidden items-center gap-8 lg:flex">
                        <a href="{{ route('home') }}" class="border-b-2 border-[#E3A72F] pb-1 text-sm font-black text-white">Accueil</a>
                        <a href="{{ route('catalog') }}" class="text-sm font-bold text-white/75 transition hover:text-[#E3A72F]">Catalogue</a>
                        <a href="{{ route('training') }}" class="text-sm font-bold text-white/75 transition hover:text-[#E3A72F]">Formations</a>
                        <a href="{{ route('service') }}" class="text-sm font-bold text-white/75 transition hover:text-[#E3A72F]">Services</a>
                        <a href="{{ route('about') }}" class="text-sm font-bold text-white/75 transition hover:text-[#E3A72F]">A propos</a>
                        <a href="#avis" class="text-sm font-bold text-white/75 transition hover:text-[#E3A72F]">Avis</a>
                        <a href="#faq" class="text-sm font-bold text-white/75 transition hover:text-[#E3A72F]">FAQ</a>
                    </nav>

                    <div class="hidden items-center gap-5 lg:flex">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-white/5 text-white/80"><x-icon name="clock" class="h-4 w-4" /></span>
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.home') }}" class="rounded-xl bg-[#D9A233] px-5 py-3 text-sm font-black text-white shadow-[0_12px_30px_rgba(217,162,51,.35)] transition hover:-translate-y-0.5">Mon espace</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm font-black text-white/85 transition hover:text-[#E3A72F]">Deconnexion</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-black text-white/85 transition hover:text-[#E3A72F]" data-loading-link>Se connecter</a>
                            <a href="{{ route('register') }}" class="rounded-xl bg-[#D9A233] px-5 py-3 text-sm font-black text-white shadow-[0_12px_30px_rgba(217,162,51,.35)] transition hover:-translate-y-0.5" data-loading-link>S'inscrire</a>
                        @endauth
                    </div>

                    <button
                        type="button"
                        class="nav-toggle grid h-11 w-11 shrink-0 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.18)] transition hover:bg-white/15 hover:scale-105 active:scale-95 lg:hidden"
                        aria-label="Ouvrir le menu"
                        aria-controls="welcome-mobile-menu"
                        aria-expanded="false"
                        data-welcome-nav-toggle
                    >
                        <span class="grid gap-1">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </span>
                    </button>
                </div>
            </header>

            <div id="welcome-mobile-menu" class="mobile-menu-root fixed inset-0 z-[60] lg:hidden" aria-hidden="true" data-welcome-mobile-menu>
                <button type="button" class="absolute inset-0 bg-black/45 backdrop-blur-sm" aria-label="Fermer le menu" data-welcome-nav-close></button>
                <aside class="mobile-menu-panel absolute right-3 top-24 w-[min(340px,calc(100vw-24px))] rounded-[2rem] border border-white/20 bg-white/[0.12] p-5 text-white shadow-[0_24px_80px_rgba(0,0,0,0.35)] backdrop-blur-2xl sm:right-4 sm:top-28 sm:w-[min(360px,calc(100vw-32px))] sm:p-6">
                    <a href="{{ route('catalog') }}" class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-welcome-nav-link>Catalogue</a>
                    <a href="{{ route('training') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-welcome-nav-link>Formations</a>
                    <a href="{{ route('service') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-welcome-nav-link>Services</a>
                    <a href="{{ route('about') }}" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-welcome-nav-link>A propos</a>
                    <a href="#avis" class="mt-2 block rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-bold text-white/80 transition hover:bg-white/10 hover:text-[#E3A72F]" data-welcome-nav-link>Avis</a>
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.home') }}" class="mt-4 block rounded-full bg-[#D9A233] px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white shadow-gold" data-welcome-nav-link>Mon espace</a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="block w-full rounded-full border border-white/20 px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white">Deconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mt-4 block rounded-full border border-white/20 px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white" data-welcome-nav-link data-loading-link>Connexion</a>
                        <a href="{{ route('register') }}" class="mt-2 block rounded-full bg-[#D9A233] px-4 py-4 text-center text-xs font-black uppercase tracking-widest text-white shadow-gold" data-welcome-nav-link data-loading-link>Inscription</a>
                    @endauth
                </aside>
            </div>

            <div class="relative z-10 mx-auto grid max-w-7xl grid-cols-[minmax(0,0.68fr)_minmax(9.5rem,1fr)] items-start gap-x-2 gap-y-4 px-3 pb-7 pt-24 min-[390px]:grid-cols-[minmax(0,0.7fr)_minmax(10.8rem,1.05fr)] min-[430px]:grid-cols-[minmax(0,0.74fr)_minmax(12rem,1.08fr)] sm:grid-cols-[minmax(0,0.85fr)_minmax(18rem,0.95fr)] sm:items-center sm:gap-x-6 sm:gap-y-8 sm:px-6 sm:pb-16 sm:pt-32 md:grid-cols-[minmax(0,0.9fr)_minmax(21rem,0.95fr)] md:gap-x-8 lg:grid-cols-[1fr_0.95fr] lg:px-8 lg:pb-20 lg:pt-36">
                <div class="min-w-0">
                    <span class="inline-flex max-w-full rounded-full border border-white/15 bg-[#000080] bg-cover bg-center px-2 py-1 text-[7px] font-black uppercase tracking-[0.08em] text-white shadow-glow sm:px-4 sm:py-2 sm:text-[10px] sm:tracking-[0.16em]" style="background-image: url('{{ asset('/assets/hero-background.jpg') }}')">Plateforme digitale</span>
                    <h1 class="mt-6 max-w-3xl text-[1.08rem] font-black leading-[1.03] tracking-normal min-[390px]:text-[1.2rem] min-[430px]:text-[1.34rem] sm:mt-10 sm:text-4xl md:text-5xl lg:text-[4.4rem]">
                        Formez-vous et lancez vos revenus <span class="text-[#D9A233]">digitaux</span>. 
                    </h1>
                    <p class="mt-3 hidden max-w-2xl text-sm font-semibold leading-7 text-white/75 sm:mt-5 sm:block sm:text-lg sm:leading-8">
                        Accedez a des formations pratiques et a des comptes digitaux selectionnes pour avancer plus vite.
                    </p>
                </div>

                <figure class="relative w-full justify-self-end sm:max-w-none lg:row-span-2">
                    <img src="{{ asset('/assets/mockup.png') }}" alt="Mockup reseaux sociaux PPMC" class="w-[112%] max-w-none object-contain drop-shadow-2xl sm:w-full sm:max-w-full">
                </figure>

                <div class="col-span-2 lg:col-span-1 lg:col-start-1">
                    <p class="mb-3 max-w-2xl text-[11px] font-semibold leading-5 text-white/75 sm:hidden">
                        Formations pratiques, comptes digitaux selectionnes et accompagnement pour avancer plus vite.
                    </p>
                    <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-3">
                        <a href="{{ route('training') }}" class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-[#D9A233] px-3 py-2.5 text-[10px] font-black text-white shadow-[0_16px_36px_rgba(217,162,51,.35)] transition hover:-translate-y-1 sm:w-auto sm:gap-2 sm:rounded-xl sm:px-6 sm:py-4 sm:text-sm">Formations <x-icon name="arrow-right" class="h-3.5 w-3.5 sm:h-4 sm:w-4" /></a>
                        <a href="{{ route('service') }}" class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-white/25 bg-white/5 px-3 py-2.5 text-[10px] font-black text-white backdrop-blur transition hover:bg-white/10 sm:w-auto sm:gap-2 sm:rounded-xl sm:px-6 sm:py-4 sm:text-sm">Comptes <x-icon name="shield" class="h-3.5 w-3.5 sm:h-4 sm:w-4" /></a>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-2 min-[430px]:grid-cols-4 sm:mt-8 sm:flex sm:flex-wrap sm:gap-7">
                        @foreach($benefits as [$icon, $label])
                            <div class="flex items-center gap-2 text-[11px] font-bold text-white/70">
                                <x-icon :name="$icon" class="h-4 w-4 text-[#E9B23B]" />
                                {{ $label }}
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-7 flex flex-wrap items-center gap-3 sm:mt-10 sm:gap-4">
                        @foreach($socials as [$icon, $label])
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-white/10 sm:h-8 sm:w-8" title="{{ $label }}">
                                <x-social-logo :name="$icon" class="h-5 w-5" />
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="offers" class="bg-white px-4 py-8 sm:px-6 sm:py-14 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="text-center">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-[#D9A233]">Nos offres</p>
                    <h2 class="mt-2 text-2xl font-black leading-tight text-[#071B3B] sm:text-4xl">Tout ce dont vous avez besoin pour reussir en ligne</h2>
                </div>

                <div class="mt-6 grid gap-4 sm:mt-8 lg:grid-cols-2">
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 shadow-premium sm:rounded-3xl sm:p-7">
                        <div class="grid grid-cols-[minmax(0,1fr)_6.75rem] items-center gap-3 min-[430px]:grid-cols-[minmax(0,1fr)_8rem] sm:grid-cols-[minmax(0,1fr)_12rem] sm:gap-5 md:grid-cols-[1fr_0.9fr] md:gap-6">
                            <div class="min-w-0">
                                <span class="grid h-9 w-9 place-items-center text-[#D9A233] sm:h-14 sm:w-14"><x-icon name="book-open" class="h-6 w-6 sm:h-8 sm:w-8" /></span>
                                <h3 class="mt-3 text-base font-black leading-tight sm:mt-5 sm:text-2xl">Formations Completes</h3>
                                <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500 sm:mt-3 sm:text-sm sm:leading-7">Des formations detaillees et pratiques pour maitriser la monetisation sur chaque reseau social.</p>
                                <ul class="mt-3 grid grid-cols-1 gap-1.5 text-[11px] font-bold text-slate-600 sm:mt-5 sm:block sm:space-y-3 sm:text-sm">
                                    @foreach(['Strategies eprouvees', 'Etapes par etape', 'Mises a jour a vie', 'Acces sur tous vos appareils'] as $item)
                                        <li class="{{ $loop->index > 1 ? 'hidden sm:flex' : 'flex' }} items-center gap-2 sm:gap-3"><x-icon name="check" class="h-3.5 w-3.5 text-[#D9A233] sm:h-4 sm:w-4" />{{ $item }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('training') }}" class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-[#D9A233] px-3 py-2.5 text-[10px] font-black text-white shadow-gold sm:mt-6 sm:w-auto sm:gap-2 sm:px-5 sm:py-3 sm:text-sm">Explorer <x-icon name="arrow-right" class="h-3.5 w-3.5 sm:h-4 sm:w-4" /></a>
                            </div>
                            <div class="rounded-2xl bg-[#F4F7FB] p-2 sm:p-4">
                                <div class="relative mx-auto flex h-24 max-w-xs items-end justify-center overflow-hidden min-[430px]:h-28 sm:h-48">
                                    <img src="{{ $deviceImages['laptop'] }}" alt="Ordinateur portable" class="h-20 w-full object-contain drop-shadow-2xl min-[430px]:h-24 sm:h-44" loading="lazy">
                                    <span class="absolute left-1/2 top-[34%] grid h-8 w-8 -translate-x-1/2 place-items-center rounded-full bg-[#D9A233] text-white shadow-gold sm:h-11 sm:w-11">
                                        <x-icon name="arrow-right" class="h-4 w-4 sm:h-5 sm:w-5" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 shadow-premium sm:rounded-3xl sm:p-7">
                        <div class="grid grid-cols-[minmax(0,1fr)_6.75rem] items-center gap-3 min-[430px]:grid-cols-[minmax(0,1fr)_8rem] sm:grid-cols-[minmax(0,1fr)_12rem] sm:gap-5 md:grid-cols-[1fr_0.75fr] md:gap-6">
                            <div class="min-w-0">
                                <span class="grid h-9 w-9 place-items-center text-[#D9A233] sm:h-14 sm:w-14"><x-icon name="users" class="h-6 w-6 sm:h-8 sm:w-8" /></span>
                                <h3 class="mt-3 text-base font-black leading-tight sm:mt-5 sm:text-2xl">Comptes Monetises</h3>
                                <p class="mt-2 line-clamp-2 text-xs font-semibold leading-5 text-slate-500 sm:mt-3 sm:text-sm sm:leading-7">Des comptes deja monetises et prets a generer des revenus des leur acquisition.</p>
                                <ul class="mt-3 grid grid-cols-1 gap-1.5 text-[11px] font-bold text-slate-600 sm:mt-5 sm:block sm:space-y-3 sm:text-sm">
                                    @foreach(['Comptes verifies', 'Monetises et actifs', 'Differentes niches', 'Support apres achat'] as $item)
                                        <li class="{{ $loop->index > 1 ? 'hidden sm:flex' : 'flex' }} items-center gap-2 sm:gap-3"><x-icon name="check" class="h-3.5 w-3.5 text-[#D9A233] sm:h-4 sm:w-4" />{{ $item }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('service') }}" class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-[#D9A233] px-3 py-2.5 text-[10px] font-black text-white shadow-gold sm:mt-6 sm:w-auto sm:gap-2 sm:px-5 sm:py-3 sm:text-sm">Voir comptes <x-icon name="arrow-right" class="h-3.5 w-3.5 sm:h-4 sm:w-4" /></a>
                            </div>
                            <div class="mx-auto w-full rounded-2xl bg-[#F4F7FB] p-2 sm:max-w-[17rem] sm:p-4">
                                <img src="{{ asset($deviceImages['phone']) }}" alt="Telephone avec reseaux sociaux" class="aspect-square w-full rounded-2xl object-cover shadow-2xl" loading="lazy">
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="about" class="bg-white px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            <div class="mx-auto max-w-7xl border-y border-slate-200 py-6 sm:py-8">
                <div class="text-center">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-[#D9A233]">Pourquoi nous choisir ?</p>
                    <h2 class="mt-2 text-2xl font-black text-[#071B3B] sm:text-3xl">La difference qui fait votre succes</h2>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-4 min-[430px]:grid-cols-2 sm:mt-8 md:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                    @foreach($features as [$icon, $title, $body])
                        <div class="flex flex-col gap-2 sm:flex-row sm:gap-4 lg:border-r lg:border-slate-200 lg:pr-5 last:border-r-0">
                            <span class="grid h-8 w-8 shrink-0 place-items-center text-[#D9A233] sm:h-10 sm:w-10"><x-icon :name="$icon" class="h-6 w-6 sm:h-7 sm:w-7" /></span>
                            <div>
                                <h3 class="text-sm font-black sm:text-base">{{ $title }}</h3>
                                <p class="mt-1 line-clamp-2 text-[11px] font-semibold leading-5 text-slate-500 sm:text-xs">{{ $body }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="avis" class="bg-white px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="text-center">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-[#D9A233]">Ils nous font confiance</p>
                    <h2 class="mt-2 text-2xl font-black text-[#071B3B] sm:text-3xl">Des resultats concrets</h2>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-2 sm:mt-8 sm:gap-4 lg:grid-cols-4">
                    @foreach($testimonials as [$name, $role, $quote, $photo])
                        <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-soft sm:p-5">
                            <div class="flex gap-1 text-[#D9A233]">
                                @for($i = 0; $i < 5; $i++)
                                    <x-icon name="sparkles" class="h-3 w-3 sm:h-4 sm:w-4" />
                                @endfor
                            </div>
                            <p class="mt-2 line-clamp-2 text-[10px] font-semibold leading-5 text-slate-600 sm:mt-4 sm:line-clamp-3 sm:text-sm sm:leading-7">"{{ $quote }}"</p>
                            <div class="mt-3 flex items-center gap-2 sm:mt-5 sm:gap-3">
                                <img src="{{ $photo }}" alt="Photo de {{ $name }}" class="h-8 w-8 shrink-0 rounded-full border border-slate-200 object-cover shadow-sm sm:h-11 sm:w-11" loading="lazy">
                                <div class="min-w-0"><p class="truncate text-xs font-black sm:text-base">{{ $name }}</p><p class="truncate text-[10px] font-bold text-slate-500 sm:text-xs">{{ $role }}</p></div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="faq" class="bg-white px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            <div class="mx-auto grid max-w-7xl gap-3 md:grid-cols-2 md:gap-4 lg:grid-cols-3">
                @foreach([
                    ['Les comptes sont-ils verifies ?', 'Oui, chaque compte est controle avant livraison.'],
                    ['Comment recevoir la formation ?', 'Apres paiement, votre acces et votre facture sont envoyes par email.'],
                    ['Le support est-il local ?', 'Oui, l accompagnement est pense pour le marche camerounais.'],
                ] as [$question, $answer])
                    <details class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                        <summary class="cursor-pointer text-sm font-black">{{ $question }}</summary>
                        <p class="mt-3 text-sm font-semibold leading-6 text-slate-500">{{ $answer }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        <section class="bg-white px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            <div class="mx-auto grid max-w-7xl gap-5 rounded-3xl bg-[#000080] bg-cover bg-center p-5 text-white shadow-premium sm:gap-6 sm:p-8 lg:grid-cols-[1.2fr_0.8fr]" style="background-image: url('{{ asset('/assets/hero-background.jpg') }}')">
                <div>
                    <span class="rounded-full border border-white/15 bg-[#000080] bg-cover bg-center px-4 py-2 text-[10px] font-black uppercase tracking-[0.15em]" style="background-image: url('{{ asset('/assets/hero-background.jpg') }}')">Pret a passer au niveau superieur ?</span>
                    <h2 class="mt-4 max-w-2xl text-2xl font-black leading-tight sm:mt-5 sm:text-5xl">Commencez des aujourd'hui</h2>
                    <p class="mt-3 max-w-xl text-sm font-semibold leading-7 text-white/70 sm:mt-4">Rejoignez des milliers d entrepreneurs qui generent deja des revenus grace a nos formations et comptes monetises.</p>
                    <ul class="mt-4 grid grid-cols-1 gap-2 text-xs font-bold text-white/75 min-[430px]:grid-cols-2 sm:mt-5 sm:text-sm">
                        @foreach(['Garantie satisfait ou rembourse 7 jours', 'Acces a vie aux formations', 'Mises a jour gratuites', 'Acces a notre communaute privee'] as $item)
                            <li class="flex items-center gap-2"><x-icon name="check" class="h-4 w-4 text-[#E9B23B]" />{{ $item }}</li>
                        @endforeach
                    </ul>
                    <div class="mt-6 flex flex-col gap-2 sm:mt-7 sm:flex-row sm:gap-3">
                        <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.home')) : route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D9A233] px-6 py-4 text-sm font-black text-white shadow-gold" data-loading-link>{{ auth()->check() ? 'Ouvrir mon espace' : 'Commencer maintenant' }} <x-icon name="arrow-right" class="h-4 w-4" /></a>
                        <a href="#faq" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 px-6 py-4 text-sm font-black text-white">En savoir plus <x-icon name="clock" class="h-4 w-4" /></a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 sm:gap-4">
                    @foreach([
                        ['Formations', '49', ['Acces a vie', 'Mises a jour incluses', 'Support dedie'], route('training'), 'Voir les formations', false],
                        ['Comptes', '99', ['Comptes verifies', 'Monetises et actifs', 'Support apres achat'], route('service'), 'Voir les comptes', true],
                    ] as [$title, $price, $items, $href, $cta, $popular])
                        <article class="relative min-w-0 rounded-2xl border border-white/20 bg-white/[0.05] p-3 sm:p-5">
                            @if($popular)
                                <span class="absolute right-2 top-2 rounded-full bg-[#D9A233] px-2 py-1 text-[8px] font-black text-white sm:right-4 sm:top-4 sm:px-3 sm:text-[10px]">Populaire</span>
                            @endif
                            <h3 class="pr-12 text-sm font-black sm:text-xl">{{ $title }}</h3>
                            <p class="mt-2 text-[10px] font-bold text-white/55 sm:mt-4 sm:text-sm">A partir de</p>
                            <p class="text-2xl font-black leading-tight sm:text-4xl"><span class="text-[11px] sm:text-xl">FCFA</span> {{ $price }}K</p>
                            <ul class="mt-3 grid gap-1.5 text-[10px] font-bold text-white/70 sm:mt-5 sm:gap-2 sm:text-xs">
                                @foreach($items as $item)
                                    <li class="{{ $loop->index > 1 ? 'hidden sm:flex' : 'flex' }} items-center gap-1.5 sm:gap-2"><x-icon name="check" class="h-3.5 w-3.5 shrink-0 text-[#E9B23B] sm:h-4 sm:w-4" /><span class="min-w-0">{{ $item }}</span></li>
                                @endforeach
                            </ul>
                            <a href="{{ $href }}" class="mt-4 block rounded-xl {{ $popular ? 'bg-[#D9A233] text-white' : 'border border-white/20 text-white' }} px-3 py-2.5 text-center text-[10px] font-black sm:mt-6 sm:px-4 sm:py-3 sm:text-xs"><span class="sm:hidden">Voir</span><span class="hidden sm:inline">{{ $cta }}</span></a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <footer class="bg-[#000080] bg-cover bg-center px-4 py-10 text-white sm:px-6 lg:px-8" style="background-image: url('{{ asset('/assets/hero-background.jpg') }}')">
            <div class="mx-auto flex max-w-7xl flex-col gap-8">
                <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('/assets/logo.png') }}" alt="PPMC" class="h-10 w-auto max-w-[4.75rem] rounded-xl object-contain">
                        <div>
                            <p class="text-xl font-black">PPMC</p>
                            <p class="mt-1 text-xs font-semibold text-white/55">au coeur numerique au service de la vision</p>
                        </div>
                    </div>

                    <nav class="flex flex-wrap gap-x-5 gap-y-2 text-sm font-bold text-white/65">
                        <a href="{{ route('catalog') }}" class="transition hover:text-[#E9B23B]">Catalogue</a>
                        <a href="{{ route('training') }}" class="transition hover:text-[#E9B23B]">Formations</a>
                        <a href="{{ route('service') }}" class="transition hover:text-[#E9B23B]">Services</a>
                        <a href="{{ route('about') }}" class="transition hover:text-[#E9B23B]">A propos</a>
                        <a href="#faq" class="transition hover:text-[#E9B23B]">FAQ</a>
                    </nav>
                </div>

                <div class="flex flex-col justify-between gap-3 border-t border-white/10 pt-6 text-xs font-semibold text-white/45 md:flex-row">
                    <p>{{ now()->year }} PPMC. Tous droits reserves.</p>
                    <p>Concu avec passion et devouement pour propulser votre succes en ligne.</p>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('[data-welcome-nav-toggle]');
            const menu = document.querySelector('[data-welcome-mobile-menu]');
            if (!toggle || !menu) return;

            const setOpen = (open) => {
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
                menu.classList.toggle('is-open', open);
                menu.setAttribute('aria-hidden', open ? 'false' : 'true');
                document.body.style.overflow = open ? 'hidden' : '';
            };

            toggle.addEventListener('click', () => {
                setOpen(toggle.getAttribute('aria-expanded') !== 'true');
            });

            menu.querySelectorAll('[data-welcome-nav-close], [data-welcome-nav-link]').forEach((element) => {
                element.addEventListener('click', () => setOpen(false));
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') setOpen(false);
            });
        });
    </script>
@endpush
