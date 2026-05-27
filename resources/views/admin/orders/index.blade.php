@extends('layouts.admin')

@section('title', 'Commandes')
@section('page_title', 'Commandes')

@section('content')
    {{-- Gestion des commandes --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-bold text-slate-500">Commandes locales, ventes Chariow enregistrees et historiques de livraison.</p>
        <a href="{{ route('admin.orders.chariow.create') }}" class="w-fit rounded-full bg-royal px-5 py-3 text-sm font-black text-white">Ajouter vente Chariow</a>
    </div>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-soft sm:flex-row">
        <select name="status" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold outline-none focus:border-royal">
            <option value="">Tous les statuts</option>
            @foreach(['pending', 'paid', 'failed', 'canceled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <button class="rounded-2xl bg-royal px-5 py-3 text-sm font-black text-white">Filtrer</button>
    </form>

    <div class="overflow-x-auto rounded-[2rem] bg-white shadow-soft">
        <table class="w-full min-w-[1120px] text-left text-sm">
            <thead class="bg-slate-50 text-xs font-black uppercase tracking-[0.14em] text-slate-400">
                <tr>
                    <th class="px-5 py-4">Client</th>
                    <th class="px-5 py-4">Produit</th>
                    <th class="px-5 py-4">Montant</th>
                    <th class="px-5 py-4">Transaction</th>
                    <th class="px-5 py-4">Statut</th>
                    <th class="px-5 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-5 py-4">
                            <p class="font-black">{{ $order->user?->name ?? 'Client supprime' }}</p>
                            <p class="text-xs font-bold text-slate-500">{{ $order->user?->email ?? 'Email indisponible' }}</p>
                        </td>
                        <td class="px-5 py-4">{{ $order->product?->title ?? 'Produit indisponible' }}</td>
                        <td class="px-5 py-4 font-black">{{ $order->formatted_amount }}</td>
                        <td class="px-5 py-4 text-xs font-bold text-slate-500">
                            <div class="flex flex-wrap items-center gap-2">
                                <p>{{ $order->payment_reference }}</p>
                                @if(str_starts_with((string) $order->payment_reference, 'CHW-'))
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black text-emerald-700">Chariow</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold">
                                    @foreach(['pending', 'paid', 'failed', 'canceled'] as $status)
                                        <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <button class="inline-flex items-center gap-1 rounded-xl bg-navy px-3 py-2 text-xs font-black text-white"><x-icon name="check" class="h-3.5 w-3.5" /> Valider</button>
                            </form>
                        </td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.orders.send', $order) }}">
                                @csrf
                                <button class="rounded-full bg-royal px-4 py-2 text-xs font-black text-white">Envoyer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-slate-500">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">{{ $orders->links() }}</div>
@endsection
