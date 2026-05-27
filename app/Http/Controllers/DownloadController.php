<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Telecharge un fichier prive avec URL signee temporaire.
     */
    public function __invoke(Request $request, string $token): StreamedResponse
    {
        try {
            $orderId = Crypt::decryptString($token);
        } catch (\Throwable) {
            abort(403, 'Lien de telechargement invalide.');
        }

        $order = Order::with('product')
            ->whereKey($orderId)
            ->where('user_id', $request->user()->id)
            ->where('status', Order::STATUS_PAID)
            ->firstOrFail();

        $path = $order->product->file_path;

        abort_if(! $path || ! Storage::disk('local')->exists($path), 404, 'Fichier indisponible.');

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = Str::slug($order->product->title) . ($extension ? '.' . $extension : '');

        return Storage::disk('local')->download($path, $fileName);
    }
}
