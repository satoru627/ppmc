<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_title',
        'product_price',
        'name',
        'email',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'product_price' => 'integer',
        ];
    }

    /**
     * Produit consulte avant la redirection vers le paiement.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
