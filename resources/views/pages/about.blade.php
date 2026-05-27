@extends('layouts.app')

@section('title', 'A propos - ' . config('app.name', 'PPMC'))
@section('nav_mode', 'dark')

@section('content')
    @php
        $imageUrl = function (string $path, string $fallback): string {
            return asset(file_exists(public_path(ltrim($path, '/'))) ? $path : $fallback);
        };

        $storyImage = $imageUrl('/assets/about/company.jpg', '/assets/training/about.avif');
    @endphp

    <section class="relative -mt-24 overflow-hidden px-4 pb-8 pt-28 text-white sm:px-6 sm:pb-20 sm:pt-36 lg:px-8 lg:pb-28">
        <div class="absolute inset-0 overflow-hidden bg-[#071B3B]">
            <img src="{{ asset('/assets/equipe.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" aria-hidden="true">
            <div class="absolute inset-0 bg-gradient-to-r from-[#071B3B]/95 via-[#071B3B]/78 to-[#071B3B]/44"></div>
            <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-[#071B3B] to-transparent"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-8 lg:grid-cols-[1.04fr_0.96fr] lg:gap-16">
            <div>
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[10px] font-black uppercase tracking-[0.16em] text-gold backdrop-blur-md sm:mb-8 sm:text-xs">
                    <span class="h-2 w-2 rounded-full bg-gold"></span>
                    Notre mission
                </p>
                <h1 class="max-w-4xl text-[2.1rem] font-black leading-[1.02] tracking-normal sm:text-6xl xl:text-[80px]">
                    A propos de <br>
                    <span class="bg-gradient-to-r from-white via-white to-gold bg-clip-text text-transparent">PPMC</span>
                </h1>
                <p class="mt-4 max-w-2xl text-sm font-semibold leading-7 text-white/72 sm:mt-8 sm:text-xl sm:leading-9">
                    
                </p>
                <div class="mt-6 grid grid-cols-2 gap-2 sm:mt-8 sm:flex sm:items-center sm:gap-3">
                    <a href="{{ route('catalog') }}" class="rounded-full bg-gold px-4 py-3 text-center text-[11px] font-black text-navy shadow-gold transition hover:scale-105 sm:px-10 sm:py-5 sm:text-sm">Catalogue</a>
                    <a href="#team" class="rounded-full border border-white/20 bg-white/10 px-4 py-3 text-center text-[11px] font-black text-white backdrop-blur-md transition hover:bg-white/15 sm:px-10 sm:py-5 sm:text-sm">Equipe</a>
                </div>
            </div>

            {{-- <div class="relative hidden lg:block">
                <div class="overflow-hidden rounded-[1.75rem] border border-white/15 bg-white/10 p-3 shadow-2xl backdrop-blur-2xl sm:rounded-[2.5rem] sm:p-5">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[1.35rem] bg-white/10 sm:rounded-[2rem]">
                        <img src="{{ $storyImage }}" alt="Activites PPMC" class="h-full w-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071B3B]/92 to-transparent p-5 sm:p-7">
                            <p class="text-[10px] font-black uppercase tracking-[0.16em] text-gold">Plateforme digitale</p>
                            <h2 class="mt-2 text-2xl font-black leading-tight sm:text-4xl">Formations, services et accompagnement.</h2>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

    <section class="bg-white px-4 py-8 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Qui sommes-nous ?</p>
                <h2 class="mt-2 text-2xl font-black leading-tight text-navy sm:mt-3 sm:text-5xl">Une entreprise basée sur la création de contenus dans divers réseaux sociaux.</h2>
                <p class="mt-4 text-sm font-semibold leading-7 text-slate-500 sm:mt-5 sm:text-base sm:leading-8">
            
                    Pixel pulse media center(PPMC) est une entreprise specialisee dans la creation de contenus pour les reseaux sociaux depuis 2023 il a pour objectif de fournir des formations, des services numeriques et un accompagnement client pour aider les utilisateurs a avancer plus vite dans leur activite en ligne.
                </p>
                <p class="mt-4 hidden text-sm font-semibold leading-7 text-slate-500 sm:block sm:text-base sm:leading-8">
                    Notre role est de rendre les parcours plus simples : choisir une offre, acheter en ligne, recevoir les informations utiles et etre accompagne quand une question apparait.
                </p>
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-4">
                @foreach($stats as $stat)
                    <div class="flex aspect-square min-w-0 flex-col justify-center rounded-2xl border border-slate-100 bg-mist p-2 text-center shadow-premium sm:rounded-[2rem] sm:p-5">
                        <p class="text-xl font-black leading-none text-navy sm:text-4xl">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-[8px] font-black uppercase leading-tight tracking-[0.06em] text-slate-500 sm:mt-3 sm:text-xs sm:tracking-[0.12em]">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-8 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-5 max-w-3xl sm:mb-10">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Domaines d activite</p>
                <h2 class="mt-2 text-2xl font-black leading-tight text-navy sm:mt-3 sm:text-5xl">Tout ce qui soutient la croissance digitale.</h2>
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-5 lg:grid-cols-3">
                @foreach($domains as $domain)
                    <article class="group overflow-hidden rounded-2xl bg-white shadow-premium transition hover:-translate-y-2 sm:rounded-[2rem]">
                        <div class="relative h-28 overflow-hidden bg-slate-100 sm:h-56">
                            <img src="{{ $imageUrl($domain['image'], $domain['fallback']) }}" alt="{{ $domain['title'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/75 via-transparent to-transparent"></div>
                            <h3 class="absolute bottom-2 left-2 right-2 text-[10px] font-black leading-tight text-white sm:hidden">{{ $domain['title'] }}</h3>
                        </div>
                        <div class="hidden p-6 sm:block sm:p-7">
                            <h3 class="text-2xl font-black leading-tight text-navy">{{ $domain['title'] }}</h3>
                            <p class="mt-3 text-sm font-semibold leading-7 text-slate-500">{{ $domain['description'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-8 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-5 flex flex-col justify-between gap-5 sm:mb-10 md:flex-row md:items-end">
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Nos services</p>
                    <h2 class="mt-2 text-2xl font-black leading-tight text-navy sm:mt-3 sm:text-5xl">Des offres pensees pour passer a l action.</h2>
                </div>
                <a href="{{ route('catalog') }}" class="hidden w-fit rounded-full bg-[#071B3B] px-6 py-4 text-xs font-black text-white shadow-premium sm:inline-flex sm:text-sm">Explorer les offres</a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
                @foreach($services as $service)
                    <article class="rounded-2xl border border-slate-100 bg-white p-4 shadow-premium transition hover:-translate-y-2 sm:rounded-[2rem] sm:p-7">
                        <span class="grid h-10 w-10 place-items-center rounded-2xl bg-royal text-white shadow-glow sm:h-12 sm:w-12">
                            <x-icon :name="$service['icon']" class="h-5 w-5 sm:h-6 sm:w-6" />
                        </span>
                        <h3 class="mt-4 text-sm font-black leading-tight text-navy sm:mt-6 sm:text-xl">{{ $service['title'] }}</h3>
                        <p class="mt-2 line-clamp-3 text-xs font-semibold leading-5 text-slate-500 sm:mt-3 sm:text-sm sm:leading-7">{{ $service['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#071B3B] px-4 py-8 text-white sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-5 max-w-3xl sm:mb-10">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-gold sm:text-sm">Partenaires</p>
                <h2 class="mt-2 text-2xl font-black leading-tight sm:mt-3 sm:text-5xl">Un reseau utile pour produire, verifier et livrer.</h2>
                <p class="mt-4 hidden text-sm font-semibold leading-7 text-white/60 sm:block sm:text-base">Les partenaires renforcent la qualite des contenus, l acquisition et les operations autour des produits digitaux.</p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-5">
                @foreach($partners as $partner)
                    <article class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] shadow-2xl backdrop-blur sm:rounded-[2rem]">
                        <div class="relative h-28 overflow-hidden sm:h-52">
                            <img src="{{ $imageUrl($partner['image'], $partner['fallback']) }}" alt="{{ $partner['name'] }}" class="h-full w-full object-cover opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#071B3B]/88 via-transparent to-transparent"></div>
                        </div>
                        <div class="p-3 sm:p-6">
                            <h3 class="text-[11px] font-black leading-tight sm:text-xl">{{ $partner['name'] }}</h3>
                            <p class="mt-2 hidden text-sm font-semibold leading-7 text-white/62 sm:block">{{ $partner['role'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-navy px-4 py-10 text-white sm:px-6 sm:py-24 lg:px-8" id="team" data-about-team-gallery>
        <div class="absolute inset-0 bg-gradient-to-b from-[#071B3B]/86 via-[#071B3B]/94 to-[#071B3B]"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-white/10"></div>
        <div class="absolute inset-x-0 bottom-0 h-px bg-white/10"></div>

        <div class="relative mx-auto max-w-7xl">
            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div class="max-w-3xl">
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-gold backdrop-blur-md sm:px-4 sm:py-2 sm:text-xs">
                        <x-icon name="users" class="h-3.5 w-3.5" />
                        Galerie equipe
                    </p>
                    <h2 class="mt-4 text-3xl font-black leading-tight tracking-normal sm:text-5xl">Equipe et fondateurs PPMC.</h2>
                    <p class="mt-3 max-w-2xl text-sm font-semibold leading-7 text-white/65 sm:text-base sm:leading-8">
                        Une equipe compacte qui combine strategie, contenu, operations et assistance client.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-black text-white/70 backdrop-blur-md" data-about-team-counter>1 / {{ count($team) }}</span>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-white/10 text-white shadow-2xl backdrop-blur-md transition hover:bg-white/15" aria-label="Membre precedent" data-about-team-prev>
                        <x-icon name="arrow-right" class="h-5 w-5 rotate-180" />
                    </button>
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-white/10 text-white shadow-2xl backdrop-blur-md transition hover:bg-white/15" aria-label="Membre suivant" data-about-team-next>
                        <x-icon name="arrow-right" class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/[0.06] shadow-2xl sm:mt-12 sm:rounded-[2rem]">
                <div class="relative h-[360px] overflow-hidden sm:h-[560px] lg:h-[620px]">
                    @foreach($team as $member)
                        <article class="absolute inset-0 opacity-0 transition duration-500" data-about-team-slide data-index="{{ $loop->index }}" aria-hidden="true">
                            <img src="{{ $imageUrl($member['image'], $member['fallback']) }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#071B3B]/24 via-transparent to-transparent"></div>
                            <span class="absolute left-4 top-4 rounded-full bg-gold px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] text-navy shadow-gold sm:left-6 sm:top-6 sm:text-xs">{{ $member['tag'] }}</span>
                        </article>
                    @endforeach

                    <div class="absolute right-4 top-4 flex gap-2 sm:right-6 sm:top-6">
                        @foreach($team as $member)
                            <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/45 transition" aria-label="Afficher {{ $member['name'] }}" data-about-team-dot="{{ $loop->index }}"></button>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-white/10 bg-[#071B3B]/92 p-5 sm:p-7 lg:p-8">
                    @foreach($team as $member)
                        <article class="hidden" data-about-team-info data-index="{{ $loop->index }}">
                            <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[10px] font-black uppercase tracking-[0.12em] text-gold ring-1 ring-white/15 backdrop-blur-md sm:text-xs">
                                <x-icon name="briefcase" class="h-3.5 w-3.5" />
                                {{ $member['role'] }}
                            </p>
                            <h3 class="mt-3 max-w-3xl text-2xl font-black leading-tight tracking-normal text-white sm:text-4xl">{{ $member['name'] }}</h3>
                            <p class="mt-3 max-w-2xl text-sm font-semibold leading-7 text-white/72 sm:text-base sm:leading-8">{{ $member['bio'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="mt-5 sm:mt-7">
                <div class="flex gap-3 overflow-x-auto pb-2 sm:gap-4" data-about-team-thumbs>
                    @foreach($team as $member)
                        <button type="button" class="group w-36 shrink-0 overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] text-left transition duration-300 hover:-translate-y-1 sm:w-48" data-about-team-thumb="{{ $loop->index }}" aria-label="Afficher {{ $member['name'] }}">
                            <span class="relative block h-28 overflow-hidden sm:h-36">
                                <img src="{{ $imageUrl($member['image'], $member['fallback']) }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover transition duration-500" data-about-team-thumb-image>
                                <span class="absolute inset-0 bg-gradient-to-t from-[#071B3B]/72 to-transparent"></span>
                            </span>
                            <span class="block p-3">
                                <span class="block truncate text-sm font-black text-white">{{ $member['name'] }}</span>
                                <span class="mt-1 block truncate text-[10px] font-black uppercase tracking-[0.1em] text-gold">{{ $member['tag'] }}</span>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mt-5 flex justify-center gap-2 sm:mt-7">
                @foreach($team as $member)
                    <button type="button" class="h-2.5 w-2.5 rounded-full bg-white/25 transition" aria-label="Afficher {{ $member['name'] }}" data-about-team-bottom-dot="{{ $loop->index }}"></button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-mist px-4 py-8 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-5 rounded-[1.5rem] bg-white p-5 shadow-premium sm:rounded-[2rem] sm:p-8 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.18em] text-royal sm:text-sm">Pret a avancer ?</p>
                <h2 class="mt-2 max-w-3xl text-xl font-black leading-tight text-navy sm:text-4xl">Explore les formations et services disponibles sur la plateforme.</h2>
            </div>
            <a href="{{ route('catalog') }}" class="shrink-0 rounded-full bg-gold px-7 py-3.5 text-center text-xs font-black text-navy shadow-gold transition hover:scale-105 sm:px-10 sm:py-5 sm:text-sm">Ouvrir le catalogue</a>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-about-team-gallery]');
                if (!root) return;

                const slides = Array.from(root.querySelectorAll('[data-about-team-slide]'));
                const infos = Array.from(root.querySelectorAll('[data-about-team-info]'));
                const thumbs = Array.from(root.querySelectorAll('[data-about-team-thumb]'));
                const dots = Array.from(root.querySelectorAll('[data-about-team-dot], [data-about-team-bottom-dot]'));
                const prev = root.querySelector('[data-about-team-prev]');
                const next = root.querySelector('[data-about-team-next]');
                const counter = root.querySelector('[data-about-team-counter]');
                if (!slides.length) return;

                let currentIndex = 0;
                let timer = null;

                const stopAutoSlide = () => {
                    if (timer) window.clearInterval(timer);
                    timer = null;
                };

                const startAutoSlide = () => {
                    stopAutoSlide();
                    timer = window.setInterval(() => {
                        goToSlide((currentIndex + 1) % slides.length);
                    }, 4500);
                };

                const goToSlide = (index) => {
                    currentIndex = (index + slides.length) % slides.length;

                    slides.forEach((slide, slideIndex) => {
                        const active = slideIndex === currentIndex;

                        slide.style.opacity = active ? '1' : '0';
                        slide.style.transform = active ? 'scale(1)' : 'scale(1.035)';
                        slide.style.pointerEvents = active ? 'auto' : 'none';
                        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
                    });

                    infos.forEach((info, infoIndex) => {
                        info.classList.toggle('hidden', infoIndex !== currentIndex);
                    });

                    dots.forEach((dot, index) => {
                        const active = index % slides.length === currentIndex;
                        dot.style.width = active ? '2rem' : '0.625rem';
                        dot.style.backgroundColor = active ? '#F4C76A' : 'rgba(255,255,255,.25)';
                        dot.setAttribute('aria-current', active ? 'true' : 'false');
                    });

                    thumbs.forEach((thumb, index) => {
                        const active = index === currentIndex;
                        const image = thumb.querySelector('[data-about-team-thumb-image]');

                        thumb.style.borderColor = active ? 'rgba(244,199,106,.78)' : 'rgba(255,255,255,.10)';
                        thumb.style.boxShadow = active ? '0 18px 48px rgba(244,199,106,.18)' : 'none';
                        thumb.style.opacity = active ? '1' : '.72';
                        if (image) image.style.filter = active ? 'blur(0) brightness(1)' : 'blur(2.5px) brightness(.76)';
                        if (image) image.style.transform = active ? 'scale(1.04)' : 'scale(1)';
                        thumb.setAttribute('aria-current', active ? 'true' : 'false');
                    });

                    if (counter) counter.textContent = `${currentIndex + 1} / ${slides.length}`;
                };

                const move = (direction) => goToSlide(currentIndex + direction);

                prev?.addEventListener('click', () => {
                    move(-1);
                    startAutoSlide();
                });

                next?.addEventListener('click', () => {
                    move(1);
                    startAutoSlide();
                });

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        goToSlide(index % slides.length);
                        startAutoSlide();
                    });
                });

                thumbs.forEach((thumb, index) => {
                    thumb.addEventListener('click', () => {
                        goToSlide(index);
                        startAutoSlide();
                    });
                });

                root.addEventListener('mouseenter', stopAutoSlide);
                root.addEventListener('mouseleave', startAutoSlide);

                goToSlide(0);
                startAutoSlide();
            });
        </script>
    @endpush
@endsection
