<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    /**
     * Liste et filtre les tickets support clients.
     */
    public function index(Request $request): View
    {
        $tickets = SupportTicket::with('user')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = '%' . $request->string('search')->toString() . '%';

                $query->where(function ($inner) use ($search): void {
                    $inner->where('subject', 'like', $search)
                        ->orWhere('message', 'like', $search)
                        ->orWhereHas('user', function ($userQuery) use ($search): void {
                            $userQuery->where('name', 'like', $search)
                                ->orWhere('email', 'like', $search)
                                ->orWhere('phone', 'like', $search);
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => SupportTicket::count(),
            'open' => SupportTicket::where('status', SupportTicket::STATUS_OPEN)->count(),
            'in_progress' => SupportTicket::where('status', SupportTicket::STATUS_IN_PROGRESS)->count(),
            'closed' => SupportTicket::where('status', SupportTicket::STATUS_CLOSED)->count(),
        ];

        return view('admin.support.index', compact('tickets', 'stats'));
    }

    /**
     * Detail d'un ticket support.
     */
    public function show(SupportTicket $ticket): View
    {
        $ticket->loadMissing('user');

        return view('admin.support.show', compact('ticket'));
    }

    /**
     * Met a jour le statut d'un ticket.
     */
    public function updateStatus(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(SupportTicket::STATUSES)],
        ]);

        $ticket->update(['status' => $data['status']]);

        return back()->with('success', 'Statut du ticket mis a jour.');
    }
}
