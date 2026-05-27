@props(['name'])

@php
    $gradientId = 'instagram-gradient-' . uniqid();
@endphp

@switch($name)
    @case('google')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M21.6 12.2c0-.7-.1-1.4-.2-2.1H12v4h5.4a4.6 4.6 0 0 1-2 3v2.5h3.3c1.9-1.8 2.9-4.3 2.9-7.4Z" fill="#4285F4"></path>
            <path d="M12 22c2.7 0 5-.9 6.7-2.4l-3.3-2.5c-.9.6-2 .9-3.4.9-2.6 0-4.8-1.7-5.6-4.1H3.1v2.6A10 10 0 0 0 12 22Z" fill="#34A853"></path>
            <path d="M6.4 13.9a6 6 0 0 1 0-3.8V7.5H3.1a10 10 0 0 0 0 9l3.3-2.6Z" fill="#FBBC05"></path>
            <path d="M12 6c1.5 0 2.8.5 3.9 1.5l2.9-2.9A9.7 9.7 0 0 0 12 2a10 10 0 0 0-8.9 5.5l3.3 2.6C7.2 7.7 9.4 6 12 6Z" fill="#EA4335"></path>
        </svg>
        @break

    @case('youtube')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="2.2" y="5.2" width="19.6" height="13.6" rx="4" fill="#FF0000"></rect>
            <path d="M10 8.7v6.6l5.8-3.3L10 8.7Z" fill="#FFFFFF"></path>
        </svg>
        @break

    @case('facebook')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path fill="#1877F2" d="M22 12.1C22 6.6 17.5 2 12 2S2 6.6 2 12.1C2 17 5.6 21.1 10.3 22v-7H7.8v-2.9h2.5V9.9c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5H15c-1.2 0-1.6.8-1.6 1.6v1.9h2.8l-.5 2.9h-2.3v7A10 10 0 0 0 22 12.1Z"></path>
            <path fill="#FFFFFF" d="m15.7 15 .5-2.9h-2.8v-1.9c0-.8.4-1.6 1.6-1.6h1.3V6.2S15.2 6 14.1 6c-2.3 0-3.8 1.4-3.8 3.9v2.2H7.8V15h2.5v7a10.4 10.4 0 0 0 3.1 0v-7h2.3Z"></path>
        </svg>
        @break

    @case('instagram')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <defs>
                <linearGradient id="{{ $gradientId }}" x1="4" y1="21" x2="20" y2="3" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#FEDA75"></stop>
                    <stop offset="0.28" stop-color="#FA7E1E"></stop>
                    <stop offset="0.55" stop-color="#D62976"></stop>
                    <stop offset="0.78" stop-color="#962FBF"></stop>
                    <stop offset="1" stop-color="#4F5BD5"></stop>
                </linearGradient>
            </defs>
            <rect x="3" y="3" width="18" height="18" rx="5" stroke="url(#{{ $gradientId }})" stroke-width="2.2"></rect>
            <circle cx="12" cy="12" r="4" stroke="url(#{{ $gradientId }})" stroke-width="2.2"></circle>
            <circle cx="17.3" cy="6.7" r="1.2" fill="#D62976"></circle>
        </svg>
        @break

    @case('tiktok')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path fill="#25F4EE" d="M15.3 3c.2 2 1.4 3.6 3.4 4.1v3.2a7 7 0 0 1-3.3-.9v5.7c0 3.4-2.3 5.6-5.5 5.6A5.2 5.2 0 0 1 4.6 15.5c0-3.2 2.4-5.4 6-5.2v3.4c-1.6-.2-2.5.5-2.5 1.7 0 1 .7 1.7 1.8 1.7 1.2 0 2-.8 2-2.4V3h3.4Z" opacity=".9"></path>
            <path fill="#FE2C55" d="M16.6 3.6c.4 1.8 1.6 3.1 3.4 3.5v3.5a7.2 7.2 0 0 1-3.7-1.1v5.8c0 3.5-2.4 5.8-5.7 5.8-2.7 0-4.8-1.9-5.3-4.3.8.8 2 1.3 3.3 1.3 3.3 0 5.7-2.3 5.7-5.8V3.6h2.3Z" opacity=".9"></path>
            <path fill="#111827" d="M16 3c.3 2.1 1.5 3.7 3.7 4.1v3.6A7.3 7.3 0 0 1 16 9.6v5.9c0 3.5-2.4 5.8-5.7 5.8A5.4 5.4 0 0 1 4.8 16c0-3.4 2.6-5.7 6.4-5.4v3.7c-1.7-.3-2.7.5-2.7 1.8 0 1 .8 1.8 1.9 1.8 1.3 0 2.1-.8 2.1-2.5V3H16Z"></path>
        </svg>
        @break

    @case('bitcoin')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="9" fill="#F7931A"></circle>
            <path d="M9 7h4.2a2.4 2.4 0 0 1 0 4.8H9m0 0h4.7a2.6 2.6 0 0 1 0 5.2H9m0-10v10m2-12v2m3-2v2m-3 10v2m3-2v2" stroke="#FFFFFF" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        @break

    @case('twitter')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" fill="#111827"></circle>
            <path d="m7 6 10 12M17 6 7 18" stroke="#FFFFFF" stroke-width="2.4" stroke-linecap="round"></path>
        </svg>
        @break

    @case('linkedin')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="2.5" y="2.5" width="19" height="19" rx="4" fill="#0A66C2"></rect>
            <path d="M7 10h3v8H7v-8Zm1.5-4a1.6 1.6 0 1 1 0 3.2 1.6 1.6 0 0 1 0-3.2ZM12 10h2.8v1.1c.5-.7 1.3-1.3 2.7-1.3 2 0 3.5 1.3 3.5 4.1V18h-3v-3.7c0-1.1-.4-1.8-1.4-1.8-.8 0-1.3.5-1.5 1.1-.1.2-.1.5-.1.8V18h-3v-8Z" fill="#FFFFFF"></path>
        </svg>
        @break

    @case('pinterest')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" fill="#E60023"></circle>
            <path d="M11.4 15.1c-.3 1.5-.7 3-1.7 4.1-.3-2.2.5-3.9.9-5.7-.7-1.1.1-3.4 1.6-2.8 1.9.7-1.7 4.4.8 4.9 2.6.5 3.6-4.5 2-6.1-2.4-2.4-7-.1-6.4 3.3.1.8 1 1.1.4 2.2-1.6-.4-2.1-1.7-2-3.4.3-3.2 2.9-5.5 5.7-5.8 3.5-.4 6.9 1.3 7.3 4.8.5 3.9-1.7 8.1-5.6 7.8-1.1-.1-2.2-.6-3-1.3Z" fill="#FFFFFF"></path>
        </svg>
        @break

    @case('snapchat')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" fill="#FFFC00"></circle>
            <path d="M12 5.4c2 0 3.3 1.5 3.3 3.8v1.6c0 .4.4.7.9.9l.9.4c.4.2.4.8 0 1-.6.3-1.1.4-1.5.5.4 1.1 1.2 1.8 2.3 2.2.4.1.4.7 0 .9-.8.4-1.7.5-2.6.5-.7.7-1.6 1.4-3.3 1.4s-2.6-.7-3.3-1.4c-.9 0-1.8-.1-2.6-.5-.4-.2-.4-.8 0-.9 1.1-.4 1.9-1.1 2.3-2.2-.4-.1-.9-.2-1.5-.5-.4-.2-.4-.8 0-1l.9-.4c.5-.2.9-.5.9-.9V9.2c0-2.3 1.3-3.8 3.3-3.8Z" fill="#FFFFFF" stroke="#111827" stroke-width=".8" stroke-linejoin="round"></path>
        </svg>
        @break

    @default
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" stroke="#071B3B" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"></path>
            <rect x="3" y="6" width="18" height="14" rx="2"></rect>
            <path d="M3 12h18"></path>
        </svg>
@endswitch
