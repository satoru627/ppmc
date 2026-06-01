@extends('layouts.admin')

@php($isEdit = $product->exists)

@section('title', $isEdit ? 'Modifier produit' : 'Ajouter produit')
@section('page_title', $isEdit ? 'Modifier produit' : 'Ajouter produit')

@section('content')
    {{-- Formulaire produit --}}
    <form method="POST" action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="max-w-4xl rounded-[2rem] bg-white p-6 shadow-soft">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-5">
            <label class="grid gap-2 text-sm font-bold">
                Titre
                <input name="title" value="{{ old('title', $product->title) }}" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
            </label>

            <label class="grid gap-2 text-sm font-bold">
                Description
                <textarea name="description" rows="6" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">{{ old('description', $product->description) }}</textarea>
            </label>

            <div class="grid gap-5 sm:grid-cols-2">
                <label class="grid gap-2 text-sm font-bold">
                    Type
                    <select name="type" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                        <option value="formation" @selected(old('type', $product->type) === 'formation')>Formation</option>
                        <option value="service" @selected(old('type', $product->type) === 'service')>Service</option>
                    </select>
                </label>
                <label class="grid gap-2 text-sm font-bold">
                    Prix en FCFA
                    <input name="price" type="number" min="500" value="{{ old('price', $product->price) }}" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                </label>
            </div>

            <label class="grid gap-2 text-sm font-bold">
                Lien de paiement Chariow
                <input name="chariow_checkout_url" type="url" value="{{ old('chariow_checkout_url', $product->chariow_checkout_url) }}" placeholder="https://..." class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                <span class="text-xs font-bold text-slate-500">Obligatoire pour vendre ce produit. Si ce champ est vide, le bouton public affiche Produit bientot disponible.</span>
            </label>

            <section class="rounded-[1.5rem] border border-amber-100 bg-amber-50/70 p-5">
                <label class="flex items-center gap-3 text-sm font-black text-navy">
                    <input type="checkbox" name="is_promoted" value="1" @checked(old('is_promoted', $product->is_promoted ?? false)) class="h-4 w-4 rounded text-royal">
                    Produit en promotion
                </label>

                <div class="mt-4 grid gap-5 sm:grid-cols-2">
                    <label class="grid gap-2 text-sm font-bold">
                        Prix promotionnel en FCFA
                        <input name="promotion_price" type="number" min="500" value="{{ old('promotion_price', $product->promotion_price) }}" class="rounded-2xl border border-amber-200 bg-white px-4 py-4 outline-none focus:border-royal">
                    </label>
                    <label class="grid gap-2 text-sm font-bold">
                        Fin de promotion
                        <input name="promotion_ends_at" type="datetime-local" value="{{ old('promotion_ends_at', $product->promotion_ends_at?->format('Y-m-d\TH:i')) }}" class="rounded-2xl border border-amber-200 bg-white px-4 py-4 outline-none focus:border-royal">
                    </label>
                </div>

                <p class="mt-4 text-xs font-bold leading-5 text-amber-800">
                    Comme il n'y a pas de lien Chariow promotionnel, verifiez que le prix configure dans Chariow correspond au prix promotionnel pendant la duree de l'offre.
                </p>
            </section>

            <div class="grid gap-5 sm:grid-cols-2">
                <label class="grid gap-2 text-sm font-bold">
                    Fichier prive du produit
                    <input name="product_file" type="file" class="rounded-2xl border border-slate-200 px-4 py-4 text-sm">
                    @if($product->file_path)
                        <span class="text-xs font-bold text-slate-500">Fichier actuel: {{ $product->file_path }}</span>
                    @endif
                </label>
                <label class="grid gap-2 text-sm font-bold">
                    Image publique
                    <input name="image" type="file" accept="image/*" class="rounded-2xl border border-slate-200 px-4 py-4 text-sm">
                    @if($product->image)
                        <span class="text-xs font-bold text-slate-500">Image actuelle: {{ $product->image }}</span>
                    @endif
                </label>
            </div>

            <label class="flex items-center gap-3 text-sm font-bold">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) class="h-4 w-4 rounded text-royal">
                Produit actif
            </label>

            <div class="flex flex-col gap-3 sm:flex-row">
                <button class="rounded-full bg-royal px-6 py-4 text-sm font-black text-white">{{ $isEdit ? 'Mettre a jour' : 'Creer' }}</button>
                <a href="{{ route('admin.products.index') }}" class="rounded-full border border-slate-200 px-6 py-4 text-center text-sm font-black text-navy">Annuler</a>
            </div>
        </div>
    </form>
@endsection
