@props(['product', 'variant' => 'card'])

@php
    $large = $variant === 'large';
    $currentClass = $large
        ? 'text-3xl font-black text-navy sm:text-4xl'
        : 'text-xs font-black text-navy sm:text-lg';
    $oldClass = $large
        ? 'text-sm font-black text-slate-400 line-through sm:text-base'
        : 'text-[11px] font-black text-slate-400 line-through sm:text-xs';
    $countdownClass = $large
        ? 'mt-3 rounded-2xl bg-rose-50 px-4 py-3 text-xs font-black text-rose-700'
        : 'mt-2 rounded-xl bg-rose-50 px-3 py-2 text-[10px] font-black text-rose-700 sm:text-xs';
@endphp

<div {{ $attributes->merge(['class' => 'min-w-0']) }}>
    @if($product->is_on_promotion)
        <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
            <span class="{{ $currentClass }}">{{ $product->formatted_current_price }}</span>
            <span class="{{ $oldClass }}">{{ $product->formatted_price }}</span>
        </div>
        <div class="{{ $countdownClass }}" data-countdown="{{ $product->promotion_ends_at?->toIso8601String() }}">
            <span data-countdown-days>--</span>j
            <span data-countdown-hours>--</span>h
            <span data-countdown-minutes>--</span>m
            <span data-countdown-seconds>--</span>s
        </div>
    @else
        <span class="{{ $currentClass }}">{{ $product->formatted_price }}</span>
    @endif
</div>
