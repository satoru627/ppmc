<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'price',
        'chariow_checkout_url',
        'file_path',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Utilise le slug pour les URL publiques.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Commandes associees au produit.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope pour afficher uniquement les produits actifs.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Prix lisible en FCFA.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Indique si ce produit doit etre achete sur Chariow.
     */
    public function hasChariowCheckout(): bool
    {
        return filled($this->chariow_checkout_url);
    }
}
