@extends('layouts.admin')

@section('title', 'Utilisateurs')
@section('page_title', 'Utilisateurs')

@section('content')
    {{-- Gestion des utilisateurs --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 flex flex-col gap-3 rounded-3xl bg-white p-4 shadow-soft sm:flex-row">
        <input name="search" value="{{ request('search') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold outline-none focus:border-royal sm:min-w-80" placeholder="Nom, email ou telephone">
        <button class="rounded-2xl bg-royal px-5 py-3 text-sm font-black text-white">Rechercher</button>
    </form>

    <div class="overflow-x-auto rounded-[2rem] bg-white shadow-soft">
        <table class="w-full min-w-[980px] text-left text-sm">
            <thead class="bg-slate-50 text-xs font-black uppercase tracking-[0.14em] text-slate-400">
                <tr>
                    <th class="px-5 py-4">Nom</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Telephone</th>
                    <th class="px-5 py-4">Role</th>
                    <th class="px-5 py-4">Historique</th>
                    <th class="px-5 py-4">Statut</th>
                    <th class="px-5 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    @php
                        $hasHistory = ($user->orders_count ?? 0) > 0 || ($user->support_tickets_count ?? 0) > 0;
                    @endphp
                    <tr>
                        <td class="px-5 py-4 font-black">{{ $user->name }}</td>
                        <td class="px-5 py-4">{{ $user->email }}</td>
                        <td class="px-5 py-4">{{ $user->phone }}</td>
                        <td class="px-5 py-4">{{ $user->role }}</td>
                        <td class="px-5 py-4 text-xs font-bold text-slate-500">
                            <p>{{ $user->orders_count ?? 0 }} commande(s)</p>
                            <p>{{ $user->support_tickets_count ?? 0 }} ticket(s)</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-black {{ $user->is_blocked ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $user->is_blocked ? 'Bloque' : 'Actif' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('admin.users.block', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-full bg-navy px-4 py-2 text-xs font-black text-white">{{ $user->is_blocked ? 'Debloquer' : 'Bloquer' }}</button>
                                </form>
                                @if($hasHistory)
                                    <span class="rounded-full border border-slate-200 px-4 py-2 text-xs font-black text-slate-400">Protege</span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur sans historique ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-full border border-red-200 px-4 py-2 text-xs font-black text-red-600">Supprimer</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-6 text-slate-500">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">{{ $users->links() }}</div>
@endsection
