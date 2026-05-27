@extends('layouts.app')

@section('title', 'Contact - ' . config('app.name', '[NOM_DU_SITE]'))

@section('content')
    <section class="relative overflow-hidden px-4 pb-12 pt-8 sm:px-6 sm:pb-16 sm:pt-16 lg:px-8">
        <div class="noise-overlay absolute inset-x-0 top-0 h-[420px] overflow-hidden bg-navy-radial lg:h-[520px]">
        </div>
        <div class="relative mx-auto max-w-7xl text-white">
            <p class="mb-5 inline-flex rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-gold backdrop-blur">Premium support desk</p>
            <h1 class="max-w-3xl text-4xl font-black leading-[0.98] tracking-normal sm:text-6xl">Contact</h1>
            <p class="mt-6 max-w-2xl text-sm font-semibold leading-7 text-white/70 sm:text-base sm:leading-8">
                Echangez avec notre equipe sur les comptes monetises, formations, services crypto et accompagnement premium.
            </p>
        </div>
    </section>

    <section class="bg-white px-4 pb-20 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.18em] text-royal">Support information</p>
                <h2 class="mt-3 text-3xl font-black leading-tight tracking-normal text-navy sm:text-4xl">Concierge help for serious digital operators.</h2>
                <p class="mt-4 text-sm font-semibold leading-7 text-slate-500">
                    Notre equipe accompagne acheteurs, etudiants, fondateurs et partenaires sur l acquisition d actifs, la formation crypto et les systemes de croissance.
                </p>
                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-1">
                    @foreach([['Email Support', 'support@wealthos.studio', 'M'], ['Sales Desk', 'Private account acquisitions', 'S'], ['Partner Office', 'Creator and crypto partnerships', 'P']] as [$title, $detail, $icon])
                        <article class="premium-card flex items-center gap-3 rounded-[1.5rem] p-4 sm:gap-4 sm:rounded-[1.75rem] sm:p-5">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-navy text-xs font-black text-gold sm:h-12 sm:w-12 sm:rounded-2xl sm:text-sm">{{ $icon }}</span>
                            <div><h3 class="font-black text-navy">{{ $title }}</h3><p class="mt-1 text-sm font-bold text-slate-500">{{ $detail }}</p></div>
                        </article>
                    @endforeach
                </div>
            </div>

            <form class="premium-card rounded-[2rem] p-6 sm:p-8" method="POST" action="{{ auth()->check() ? route('client.support.store') : route('contact.submit') }}">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-2 text-sm font-black text-navy">Nom
                        <input name="name" value="{{ auth()->user()->name ?? old('name') }}" class="h-14 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white" placeholder="Votre nom">
                    </label>
                    <label class="grid gap-2 text-sm font-black text-navy">Email
                        <input name="email" value="{{ auth()->user()->email ?? old('email') }}" class="h-14 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white" placeholder="vous@entreprise.com" type="email">
                    </label>
                </div>
                <label class="mt-4 grid gap-2 text-sm font-black text-navy">Sujet
                    <input name="subject" required class="h-14 rounded-2xl border border-slate-200 bg-mist px-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white" placeholder="Achat, formation ou partenariat">
                </label>
                <label class="mt-4 grid gap-2 text-sm font-black text-navy">Message
                    <textarea name="message" required class="min-h-36 resize-none rounded-2xl border border-slate-200 bg-mist p-4 text-sm font-semibold outline-none transition focus:border-royal focus:bg-white" placeholder="Dites-nous ce que vous voulez construire.">{{ old('message') }}</textarea>
                </label>
                @auth
                    <button class="mt-6 w-full rounded-full bg-royal px-6 py-4 text-sm font-black text-white shadow-glow transition hover:-translate-y-1 hover:bg-navy">Envoyer au support</button>
                @else
                    <a href="{{ route('login') }}" class="mt-6 block w-full rounded-full bg-royal px-6 py-4 text-center text-sm font-black text-white shadow-glow transition hover:-translate-y-1 hover:bg-navy">Se connecter pour envoyer</a>
                @endauth
            </form>
        </div>
    </section>
@endsection
