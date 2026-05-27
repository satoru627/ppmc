<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    /**
     * Genere une facture PDF privee pour une commande payee.
     */
    public function generateForOrder(Order $order): Invoice
    {
        $order->loadMissing(['user', 'product', 'invoice']);

        if ($order->invoice && $order->invoice->pdf_path) {
            return $order->invoice;
        }

        $invoiceNumber = $order->invoice?->invoice_number ?: $this->buildInvoiceNumber($order);

        $invoice = Invoice::firstOrCreate(
            ['order_id' => $order->id],
            ['invoice_number' => $invoiceNumber]
        );

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'order' => $order,
            'siteName' => config('app.name', '[NOM_DU_SITE]'),
        ])->setPaper('a4');

        $path = 'invoices/' . $invoice->invoice_number . '.pdf';

        Storage::disk('local')->put($path, $pdf->output());
        $invoice->update(['pdf_path' => $path]);

        return $invoice->fresh();
    }

    /**
     * Cree un numero de facture stable et lisible.
     */
    private function buildInvoiceNumber(Order $order): string
    {
        return 'FAC-' . now()->format('Ymd') . '-' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT);
    }
}
