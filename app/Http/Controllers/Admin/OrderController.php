<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminChariowSaleRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Liste des commandes.
     */
    public function index(Request $request): View
    {
        $orders = Order::with(['user', 'product', 'invoice'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Formulaire d'ajout manuel d'une vente Chariow confirmee.
     */
    public function createChariowSale(): View
    {
        $products = Product::orderBy('title')->get(['id', 'title', 'price']);

        return view('admin.orders.chariow-sale', compact('products'));
    }

    /**
     * Enregistre une vente Chariow dans les commandes locales.
     */
    public function storeChariowSale(AdminChariowSaleRequest $request, InvoiceService $invoiceService): RedirectResponse
    {
        $data = $request->validated();
        $product = Product::findOrFail($data['product_id']);

        if (filled($data['customer_phone']) && User::where('phone', $data['customer_phone'])
            ->where('email', '!=', $data['customer_email'])
            ->exists()) {
            return back()
                ->withInput()
                ->withErrors(['customer_phone' => 'Ce telephone est deja associe a un autre client.']);
        }

        $user = User::firstOrCreate(
            ['email' => $data['customer_email']],
            [
                'name' => $data['customer_name'],
                'phone' => $data['customer_phone'] ?: null,
                'password' => Hash::make(Str::random(32)),
                'role' => 'client',
            ]
        );

        $userData = [
            'name' => $data['customer_name'],
        ];

        if (filled($data['customer_phone'])) {
            $userData['phone'] = $data['customer_phone'];
        }

        $user->fill($userData)->save();

        $reference = $this->normalizeChariowReference($data['chariow_reference']);

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $data['amount'],
            'status' => Order::STATUS_PAID,
            'payment_reference' => $reference,
            'paid_at' => now(),
        ]);

        $invoiceService->generateForOrder($order->fresh(['user', 'product', 'invoice']));

        return redirect()
            ->route('admin.orders.index', ['status' => Order::STATUS_PAID])
            ->with('success', 'Vente Chariow ajoutee au dashboard.');
    }

    /**
     * Met a jour le statut d'une commande.
     */
    public function updateStatus(OrderStatusRequest $request, Order $order, InvoiceService $invoiceService): RedirectResponse
    {
        $data = $request->validated();
        $status = $data['status'];

        $order->update([
            'status' => $status,
            'paid_at' => $status === Order::STATUS_PAID ? ($order->paid_at ?: now()) : $order->paid_at,
        ]);

        if ($order->fresh()->isPaid()) {
            $invoiceService->generateForOrder($order->fresh());
        }

        return back()->with('success', 'Statut de commande mis a jour.');
    }

    /**
     * Envoie manuellement le contenu achete au client.
     */
    public function send(Order $order, InvoiceService $invoiceService): RedirectResponse
    {
        $order->loadMissing(['user', 'product', 'invoice']);

        if (! $order->isPaid()) {
            return back()->withErrors(['order' => 'La commande doit etre payee avant envoi manuel.']);
        }

        $invoiceService->generateForOrder($order);

        $downloadUrl = URL::temporarySignedRoute(
            'client.download',
            now()->addHours(48),
            ['token' => Crypt::encryptString((string) $order->id)]
        );

        Mail::to($order->user->email)->send(new OrderConfirmed($order->fresh(['user', 'product', 'invoice']), $downloadUrl));

        return back()->with('success', 'Email de livraison envoye au client.');
    }

    /**
     * Prefixe les references Chariow pour les distinguer des anciens paiements.
     */
    private function normalizeChariowReference(string $reference): string
    {
        $reference = trim($reference);

        if (str_starts_with(strtoupper($reference), 'CHW-')) {
            return 'CHW-' . substr($reference, 4);
        }

        return 'CHW-' . $reference;
    }
}
