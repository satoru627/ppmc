<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRequest;
use Illuminate\Http\RedirectResponse;

class SupportTicketController extends Controller
{
    /**
     * Enregistre une demande de support client.
     */
    public function store(SupportTicketRequest $request): RedirectResponse
    {
        $request->user()->supportTickets()->create($request->validated());

        return back()->with('success', 'Votre demande a ete envoyee au support.');
    }
}
