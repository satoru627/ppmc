@extends('layouts.admin')

@section('title', 'Produits')
@section('page_title', 'Produits')

@section('content')
    {{-- Liste admin des produits --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-bold text-slate-500">Formations et services vendus sur la plateforme.</p>
        <a href="{{ route('admin.products.create') }}" class="w-fit rounded-full bg-royal px-5 py-3 text-sm font-black text-white">Ajouter</a>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        @forelse($products as $product)
            <article class="rounded-[2rem] bg-white p-5 shadow-soft">
                <div class="flex gap-4">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/assets/training/digital-products.jpg') }}" alt="{{ $product->title }}" class="h-24 w-24 rounded-2xl object-cover">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full bg-royal/10 px-3 py-1 text-xs font-black text-royal">{{ $product->type }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500">{{ $product->is_active ? 'Actif' : 'Inactif' }}</span>
                            @if($product->hasChariowCheckout())
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">Chariow</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700">Lien Chariow manquant</span>
                            @endif
                        </div>
                        <h2 class="mt-3 truncate text-lg font-black">{{ $product->title }}</h2>
                        <p class="mt-1 text-sm font-black text-royal">{{ $product->formatted_price }}</p>
                    </div>
                </div>
                <div class="mt-5 flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-full bg-navy px-4 py-2 text-sm font-black text-white">Modifier</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ou desactiver ce produit ?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-full border border-red-200 px-4 py-2 text-sm font-black text-red-600">Supprimer</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="rounded-[2rem] bg-white p-8 text-sm font-bold text-slate-500 shadow-soft">Aucun produit cree.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $products->links() }}</div>
@endsection
