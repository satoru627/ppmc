<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderConfirmed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order,
        public string $downloadUrl
    ) {
        $this->order->loadMissing(['user', 'product', 'invoice']);
    }

    /**
     * Sujet de l'email de confirmation.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Paiement confirme - ' . $this->order->product->title
        );
    }

    /**
     * Vue Blade utilisee pour le message.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmed',
            with: [
                'order' => $this->order,
                'downloadUrl' => $this->downloadUrl,
                'siteName' => config('app.name', '[NOM_DU_SITE]'),
            ]
        );
    }

    /**
     * Joint la facture PDF si elle existe.
     */
    public function attachments(): array
    {
        $path = $this->order->invoice?->pdf_path;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $path)
                ->as($this->order->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
