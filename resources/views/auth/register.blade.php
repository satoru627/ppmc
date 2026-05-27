@extends('layouts.app')

@section('title', 'Inscription - ' . config('app.name', '[NOM_DU_SITE]'))
@section('nav_mode', 'dark')

@section('content')
    <section class="relative -mt-24 min-h-screen overflow-hidden bg-navy px-4 pb-10 pt-28 text-white sm:px-6 sm:pb-14 sm:pt-32 lg:px-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(217,162,51,0.22),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(255,255,255,0.10),transparent_30%)]"></div>

        <div class="relative mx-auto flex min-h-[calc(100vh-9rem)] max-w-5xl items-center">
            <div class="grid w-full overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 shadow-2xl backdrop-blur-2xl lg:min-h-[590px] lg:grid-cols-2">
                <div class="flex flex-col justify-center p-5 sm:p-7 lg:p-10">
                    <div class="mx-auto w-full max-w-md">
                        <div class="relative h-32 overflow-hidden rounded-[1.35rem] lg:hidden">
                            <img src="{{ asset('assets/devices/photo_4_2026-05-26_10-25-32.jpg') }}" alt="Plateforme de formation PPMC" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/75 to-transparent"></div>
                        </div>

                        <div class="mt-6 text-center lg:text-left">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-gold">Nouveau client</p>
                            <h1 class="mt-3 text-3xl font-black tracking-tight text-white sm:text-4xl">Ouvrir un compte</h1>
                            <p class="mx-auto mt-2 max-w-md text-sm font-semibold leading-6 text-white/65 lg:mx-0">
                                Creez votre espace pour acheter vos formations et retrouver vos commandes.
                            </p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('auth.google.redirect') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-navy shadow-premium transition hover:-translate-y-1 hover:border-gold/60 active:translate-y-0" data-loading-link>
                                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-white shadow-sm ring-1 ring-slate-100">
                                    <x-social-logo name="google" class="h-5 w-5" />
                                </span>
                                Continuer avec Google
                            </a>
                        </div>

                        <div class="my-5 flex items-center gap-3">
                            <span class="h-px flex-1 bg-white/10"></span>
                            <span class="px-2 text-[10px] font-black uppercase tracking-[0.16em] text-white/40">ou formulaire</span>
                            <span class="h-px flex-1 bg-white/10"></span>
                        </div>

                        <form class="grid gap-4" method="POST" action="{{ route('register') }}" data-loading-form>
                            @csrf

                            <label class="grid gap-2 text-sm font-black text-white">
                                Nom complet
                                <input name="name" value="{{ old('name') }}" required class="h-12 rounded-2xl border border-white/10 bg-white/10 px-5 text-sm font-semibold text-white outline-none transition placeholder:text-white/30 focus:border-gold focus:bg-white/15" placeholder="Votre nom">
                            </label>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="grid gap-2 text-sm font-black text-white">
                                    Email
                                    <input name="email" type="email" value="{{ old('email') }}" required class="h-12 rounded-2xl border border-white/10 bg-white/10 px-5 text-sm font-semibold text-white outline-none transition placeholder:text-white/30 focus:border-gold focus:bg-white/15" placeholder="nom@exemple.com">
                                </label>
                                <label class="grid gap-2 text-sm font-black text-white">
                                    Telephone
                                    <input name="phone" value="{{ old('phone') }}" required class="h-12 rounded-2xl border border-white/10 bg-white/10 px-5 text-sm font-semibold text-white outline-none transition placeholder:text-white/30 focus:border-gold focus:bg-white/15" placeholder="+237 6XX XXX XXX">
                                </label>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="grid gap-2 text-sm font-black text-white">
                                    Mot de passe
                                    <input name="password" type="password" required class="h-12 rounded-2xl border border-white/10 bg-white/10 px-5 text-sm font-semibold text-white outline-none transition focus:border-gold focus:bg-white/15">
                                </label>
                                <label class="grid gap-2 text-sm font-black text-white">
                                    Confirmation
                                    <input name="password_confirmation" type="password" required class="h-12 rounded-2xl border border-white/10 bg-white/10 px-5 text-sm font-semibold text-white outline-none transition focus:border-gold focus:bg-white/15">
                                </label>
                            </div>

                            <button class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gold px-6 py-3.5 text-sm font-black text-navy shadow-gold transition hover:-translate-y-1 active:translate-y-0" data-loading-submit>
                                Creer mon compte
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </button>

                            <p class="text-center text-xs font-bold text-white/50">
                                Deja membre ?
                                <a href="{{ route('login') }}" class="font-black text-gold transition hover:text-white" data-loading-link>Se connecter</a>
                            </p>
                        </form>
                    </div>
                </div>

                <aside class="relative hidden min-h-full overflow-hidden bg-navy lg:flex">
                    <img src="{{ asset('assets/devices/photo_4_2026-05-26_10-25-32.jpg') }}" alt="Plateforme de formation PPMC" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-br from-navy/90 via-navy/45 to-gold/20"></div>
                    <div class="relative mt-auto p-10 text-white">
                        <p class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-gold backdrop-blur">
                            Espace client
                        </p>
                        <h2 class="mt-5 max-w-md text-3xl font-black leading-tight tracking-tight xl:text-4xl">
                            Un compte pour suivre toutes vos ressources digitales.
                        </h2>
                        <div class="mt-6 flex flex-wrap gap-x-5 gap-y-2 text-sm font-black text-white/85">
                            <span>Formations</span>
                            <span>Commandes</span>
                            <span>Support client</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
