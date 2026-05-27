<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    /**
     * Tableau de bord client.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'paid_orders' => $user->orders()->where('status', Order::STATUS_PAID)->count(),
            'pending_orders' => $user->orders()->where('status', Order::STATUS_PENDING)->count(),
            'total_orders' => $user->orders()->count(),
            'paid_amount' => (int) $user->orders()->where('status', Order::STATUS_PAID)->sum('amount'),
            'support_tickets' => $user->supportTickets()->count(),
        ];

        $recentOrders = $user->orders()
            ->with(['product', 'invoice'])
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * Historique des achats.
     */
    public function orders(Request $request): View
    {
        $user = $request->user();

        $orderStats = [
            'total' => $user->orders()->count(),
            'paid' => $user->orders()->where('status', Order::STATUS_PAID)->count(),
            'pending' => $user->orders()->where('status', Order::STATUS_PENDING)->count(),
            'paid_amount' => (int) $user->orders()->where('status', Order::STATUS_PAID)->sum('amount'),
        ];

        $orders = $user
            ->orders()
            ->with(['product', 'invoice'])
            ->latest()
            ->paginate(8);

        return view('client.orders', compact('orders', 'orderStats'));
    }

    /**
     * Formulaire support et historique des tickets.
     */
    public function support(Request $request): View
    {
        $tickets = $request->user()
            ->supportTickets()
            ->latest()
            ->paginate(10);

        return view('client.support', compact('tickets'));
    }

    /**
     * Telechargement de la facture PDF d'une commande payee.
     */
    public function downloadInvoice(Request $request, Order $order, InvoiceService $invoiceService): StreamedResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless($order->isPaid(), 403);

        $invoice = $order->invoice ?: $invoiceService->generateForOrder($order);

        abort_if(! $invoice->pdf_path || ! Storage::disk('local')->exists($invoice->pdf_path), 404);

        return Storage::disk('local')->download($invoice->pdf_path, $invoice->invoice_number . '.pdf');
    }
}
