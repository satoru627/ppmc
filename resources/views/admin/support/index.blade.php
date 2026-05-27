@extends('layouts.admin')

@section('title', 'Support')
@section('page_title', 'Support client')

@section('content')
    <div class="mb-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['Total', $stats['total'] ?? 0, 'bg-slate-100 text-navy'],
            ['Ouverts', $stats['open'] ?? 0, 'bg-royal/10 text-royal'],
            ['En traitement', $stats['in_progress'] ?? 0, 'bg-gold/20 text-[#805B08]'],
            ['Fermes', $stats['closed'] ?? 0, 'bg-emerald-50 text-emerald-700'],
        ] as [$label, $value, $classes])
            <article class="rounded-[1.5rem] bg-white p-5 shadow-soft">
                <p class="text-xs font-black uppercase tracking-[0.14em] text-slate-400">{{ $label }}</p>
                <p class="mt-3 text-3xl font-black text-navy">{{ $value }}</p>
                <span class="mt-4 inline-flex rounded-full px-3 py-1 text-xs font-black {{ $classes }}">Tickets</span>
            </article>
        @endforeach
    </div>

    <form method="GET" action="{{ route('admin.support.index') }}" class="mb-6 grid gap-3 rounded-3xl bg-white p-4 shadow-soft md:grid-cols-[1fr_220px_auto]">
        <input name="search" value="{{ request('search') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold outline-none focus:border-royal" placeholder="Sujet, message, client, email ou telephone">
        <select name="status" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold outline-none focus:border-royal">
            <option value="">Tous les statuts</option>
            @foreach(\App\Models\SupportTicket::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ match ($status) {
                        \App\Models\SupportTicket::STATUS_CLOSED => 'Ferme',
                        \App\Models\SupportTicket::STATUS_IN_PROGRESS => 'En traitement',
                        default => 'Ouvert',
                    } }}
                </option>
            @endforeach
        </select>
        <button class="rounded-2xl bg-royal px-5 py-3 text-sm font-black text-white">Filtrer</button>
    </form>

    <div class="overflow-x-auto rounded-[2rem] bg-white shadow-soft">
        <table class="w-full min-w-[980px] text-left text-sm">
            <thead class="bg-slate-50 text-xs font-black uppercase tracking-[0.14em] text-slate-400">
                <tr>
                    <th class="px-5 py-4">Client</th>
                    <th class="px-5 py-4">Ticket</th>
                    <th class="px-5 py-4">Statut</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tickets as $ticket)
                    @php($client = $ticket->user)
                    <tr>
                        <td class="px-5 py-4">
                            <p class="font-black text-navy">{{ $client?->name ?? 'Client supprime' }}</p>
                            <p class="text-xs font-bold text-slate-500">{{ $client?->email ?? 'Email indisponible' }}</p>
                            <p class="text-xs font-bold text-slate-400">{{ $client?->phone }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="font-black text-navy">{{ $ticket->subject }}</p>
                            <p class="mt-1 line-clamp-2 max-w-xl text-xs font-semibold leading-5 text-slate-500">{{ $ticket->message }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-black ring-1 {{ $ticket->statusBadgeClass() }}">{{ $ticket->statusLabel() }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs font-bold text-slate-500">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.support.show', $ticket) }}" class="rounded-full bg-navy px-4 py-2 text-xs font-black text-white">Voir</a>
                                @if($client?->email)
                                    <a href="mailto:{{ $client->email }}?subject={{ rawurlencode('Re: ' . $ticket->subject) }}" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-black text-navy">Repondre</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-sm font-bold text-slate-500">Aucun ticket support.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">{{ $tickets->links() }}</div>
@endsection
