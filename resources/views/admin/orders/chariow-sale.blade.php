@extends('layouts.admin')

@section('title', 'Ajouter vente Chariow')
@section('page_title', 'Ajouter vente Chariow')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-bold text-slate-500">Enregistrez ici une vente deja confirmee dans Chariow pour alimenter le dashboard local.</p>
        <a href="{{ route('admin.orders.index') }}" class="w-fit rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-black text-navy shadow-soft">Retour commandes</a>
    </div>

    <form method="POST" action="{{ route('admin.orders.chariow.store') }}" class="max-w-4xl rounded-[2rem] bg-white p-6 shadow-soft" data-chariow-sale-form>
        @csrf

        <div class="grid gap-5">
            <label class="grid gap-2 text-sm font-bold">
                Produit vendu
                <select name="product_id" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal" data-product-select>
                    <option value="">Selectionner un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" @selected((int) old('product_id') === $product->id)>
                            {{ $product->title }} - {{ $product->formatted_price }}
                        </option>
                    @endforeach
                </select>
            </label>

            <div class="grid gap-5 sm:grid-cols-2">
                <label class="grid gap-2 text-sm font-bold">
                    Nom du client
                    <input name="customer_name" value="{{ old('customer_name') }}" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                </label>

                <label class="grid gap-2 text-sm font-bold">
                    Email du client
                    <input name="customer_email" type="email" value="{{ old('customer_email') }}" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                </label>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <label class="grid gap-2 text-sm font-bold">
                    Telephone du client
                    <input name="customer_phone" value="{{ old('customer_phone') }}" class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                </label>

                <label class="grid gap-2 text-sm font-bold">
                    Montant paye en FCFA
                    <input name="amount" type="number" min="1" value="{{ old('amount') }}" required class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal" data-amount-input>
                </label>
            </div>

            <label class="grid gap-2 text-sm font-bold">
                Reference Chariow
                <input name="chariow_reference" value="{{ old('chariow_reference') }}" required placeholder="Ex: CHW-123456 ou reference Chariow" class="rounded-2xl border border-slate-200 px-4 py-4 outline-none focus:border-royal">
                <span class="text-xs font-bold text-slate-500">La reference sera enregistree avec le prefixe CHW- si elle ne l'a pas deja.</span>
            </label>

            <div class="rounded-3xl bg-mist p-5 text-sm font-semibold leading-7 text-slate-600">
                Cette action cree une commande locale en statut paye, genere une facture et met a jour les statistiques du dashboard. L'acces a la formation reste gere par Chariow.
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <button class="rounded-full bg-royal px-6 py-4 text-sm font-black text-white">Enregistrer la vente</button>
                <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-slate-200 px-6 py-4 text-center text-sm font-black text-navy">Annuler</a>
            </div>
        </div>
    </form>

    <script>
        const productSelect = document.querySelector('[data-product-select]');
        const amountInput = document.querySelector('[data-amount-input]');

        productSelect?.addEventListener('change', () => {
            const price = productSelect.selectedOptions[0]?.dataset.price;

            if (price) {
                amountInput.value = price;
            }
        });
    </script>
@endsection
