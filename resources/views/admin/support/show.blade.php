@extends('layouts.admin')

@section('title', 'Ticket support')
@section('page_title', 'Ticket support')

@section('content')
    @php($client = $ticket->user)

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('admin.support.index') }}" class="w-fit rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-black text-navy shadow-soft">Retour aux tickets</a>
        <span class="w-fit rounded-full px-4 py-2 text-xs font-black ring-1 {{ $ticket->statusBadgeClass() }}">{{ $ticket->statusLabel() }}</span>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
        <section class="rounded-[2rem] bg-white p-6 shadow-soft">
            <div class="flex flex-col gap-3 border-b border-slate-100 pb-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-royal">Sujet</p>
                    <h2 class="mt-2 text-2xl font-black leading-tight text-navy">{{ $ticket->subject }}</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-black text-slate-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="mt-6 rounded-[1.5rem] bg-mist p-5">
                <p class="text-xs font-black uppercase tracking-[0.14em] text-slate-400">Message client</p>
                <div class="mt-4 whitespace-pre-line text-sm font-semibold leading-8 text-slate-700">{{ $ticket->message }}</div>
            </div>
        </section>

        <aside class="grid gap-5">
            <section class="rounded-[2rem] bg-white p-5 shadow-soft">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-royal">Client</p>
                <div class="mt-4 grid gap-3 text-sm font-bold">
                    <div>
                        <p class="text-slate-400">Nom</p>
                        <p class="mt-1 text-navy">{{ $client?->name ?? 'Client supprime' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Email</p>
                        <p class="mt-1 break-words text-navy">{{ $client?->email ?? 'Email indisponible' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Telephone</p>
                        <p class="mt-1 text-navy">{{ $client?->phone ?? 'Indisponible' }}</p>
                    </div>
                </div>

                @if($client?->email)
                    <a href="mailto:{{ $client->email }}?subject={{ rawurlencode('Re: ' . $ticket->subject) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-full bg-royal px-5 py-3 text-sm font-black text-white">Repondre par email</a>
                @endif
            </section>

            <section class="rounded-[2rem] bg-white p-5 shadow-soft">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-royal">Traitement</p>
                <form method="POST" action="{{ route('admin.support.status', $ticket) }}" class="mt-4 grid gap-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold outline-none focus:border-royal">
                        @foreach(\App\Models\SupportTicket::STATUSES as $status)
                            <option value="{{ $status }}" @selected($ticket->status === $status)>
                                {{ match ($status) {
                                    \App\Models\SupportTicket::STATUS_CLOSED => 'Ferme',
                                    \App\Models\SupportTicket::STATUS_IN_PROGRESS => 'En traitement',
                                    default => 'Ouvert',
                                } }}
                            </option>
                        @endforeach
                    </select>
                    <button class="rounded-full bg-navy px-5 py-3 text-sm font-black text-white">Mettre a jour</button>
                </form>
            </section>
        </aside>
    </div>
@endsection
