<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #172033; font-size: 13px; line-height: 1.5; }
        .header { background: #E8184A; color: white; padding: 28px; border-radius: 18px; }
        .header h1 { margin: 0; font-size: 28px; }
        .muted { color: #64748b; }
        .grid { width: 100%; margin-top: 28px; }
        .grid td { vertical-align: top; width: 50%; }
        .box { border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 28px; }
        table.items th { background: #f7f8fb; text-align: left; padding: 12px; font-size: 11px; text-transform: uppercase; color: #64748b; }
        table.items td { border-bottom: 1px solid #e2e8f0; padding: 12px; }
        .total { text-align: right; margin-top: 24px; font-size: 18px; font-weight: bold; color: #E8184A; }
    </style>
</head>
<body>
    {{-- Facture PDF generee par DomPDF --}}
    <div class="header">
        <h1>Facture {{ $invoice->invoice_number }}</h1>
        <p>{{ $siteName }}</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="box">
                    <strong>Client</strong><br>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}<br>
                    {{ $order->user->phone }}
                </div>
            </td>
            <td>
                <div class="box">
                    <strong>Commande</strong><br>
                    Reference: #{{ $order->id }}<br>
                    Reference paiement: {{ $order->payment_reference }}<br>
                    Date paiement: {{ optional($order->paid_at)->format('d/m/Y H:i') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Type</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->product->title }}</td>
                <td>{{ ucfirst($order->product->type) }}</td>
                <td>{{ $order->formatted_amount }}</td>
            </tr>
        </tbody>
    </table>

    <p class="total">Total TTC: {{ $order->formatted_amount }}</p>
    <p class="muted">Facture generee automatiquement apres confirmation du paiement.</p>
</body>
</html>
