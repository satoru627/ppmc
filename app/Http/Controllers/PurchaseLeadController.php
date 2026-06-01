<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseLeadController extends Controller
{
    /**
     * Enregistre les coordonnees optionnelles avant la redirection Chariow.
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        abort_unless($product->is_active && $product->hasChariowCheckout(), 404);

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:190'],
        ]);

        $name = trim((string) ($validated['name'] ?? ''));
        $email = trim((string) ($validated['email'] ?? ''));

        if ($name === '' && $email === '') {
            return response()->json(['saved' => false]);
        }

        $lead = PurchaseLead::create([
            'product_id' => $product->id,
            'product_title' => $product->title,
            'product_price' => $product->current_price,
            'name' => $name !== '' ? $name : null,
            'email' => $email !== '' ? Str::lower($email) : null,
            'status' => 'pending_payment',
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 500, ''),
        ]);

        return response()->json([
            'saved' => true,
            'id' => $lead->id,
        ]);
    }
}
