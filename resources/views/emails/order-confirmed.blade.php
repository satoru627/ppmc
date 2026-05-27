<!doctype html>
<html lang="fr">
<body style="margin:0;background:#f7f8fb;font-family:Arial,sans-serif;color:#172033;">
    {{-- Email de livraison apres paiement confirme --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f7f8fb;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:24px;overflow:hidden;">
                    <tr>
                        <td style="background:#E8184A;color:#ffffff;padding:28px;">
                            <h1 style="margin:0;font-size:26px;">Paiement confirme</h1>
                            <p style="margin:10px 0 0;font-size:14px;">{{ $siteName }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="font-size:16px;line-height:1.7;">Bonjour {{ $order->user->name }},</p>
                            <p style="font-size:16px;line-height:1.7;">
                                Votre achat <strong>{{ $order->product->title }}</strong> est confirme. Le lien ci-dessous est securise et valable pendant 48h.
                            </p>
                            <p style="margin:30px 0;">
                                <a href="{{ $downloadUrl }}" style="background:#E8184A;color:#ffffff;text-decoration:none;padding:14px 22px;border-radius:999px;font-weight:bold;">Telecharger mon contenu</a>
                            </p>
                            <p style="font-size:14px;line-height:1.7;color:#64748b;">Votre facture PDF est jointe si elle a ete generee. Vous pouvez aussi la retrouver dans votre espace client.</p>
                            <p style="font-size:14px;line-height:1.7;color:#64748b;">Montant: <strong>{{ $order->formatted_amount }}</strong></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
