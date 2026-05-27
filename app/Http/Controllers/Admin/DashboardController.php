<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tableau de bord administrateur.
     */
    public function index(): View
    {
        $stats = $this->buildStats();

        $latestOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(8)
            ->get();

        $popularProducts = $this->popularProducts();

        return view('admin.dashboard', compact('stats', 'latestOrders', 'popularProducts'));
    }

    /**
     * Page statistiques detaillees.
     */
    public function stats(): View
    {
        $stats = $this->buildStats();
        $popularProducts = $this->popularProducts(10);

        $monthlyRevenue = Order::where('status', Order::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->selectRaw('DATE_FORMAT(paid_at, "%Y-%m") as month, SUM(amount) as revenue, COUNT(*) as sales')
            ->groupBy('month')
            ->orderByDesc('month')
            ->take(12)
            ->get();

        return view('admin.stats', compact('stats', 'popularProducts', 'monthlyRevenue'));
    }

    /**
     * Calcule les indicateurs principaux.
     */
    private function buildStats(): array
    {
        return [
            'revenue' => Order::where('status', Order::STATUS_PAID)->sum('amount'),
            'sales' => Order::where('status', Order::STATUS_PAID)->count(),
            'pending_orders' => Order::where('status', Order::STATUS_PENDING)->count(),
            'products' => Product::count(),
            'clients' => User::where('role', 'client')->count(),
            'open_tickets' => SupportTicket::where('status', SupportTicket::STATUS_OPEN)->count(),
        ];
    }

    /**
     * Produits les plus vendus.
     */
    private function popularProducts(int $limit = 5)
    {
        return Product::withCount([
            'orders as paid_orders_count' => fn (Builder $query) => $query->where('status', Order::STATUS_PAID),
        ])
            ->orderByDesc('paid_orders_count')
            ->take($limit)
            ->get();
    }
}
