<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'price',
        'is_promoted',
        'promotion_price',
        'promotion_ends_at',
        'chariow_checkout_url',
        'file_path',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_promoted' => 'boolean',
            'promotion_price' => 'integer',
            'promotion_ends_at' => 'datetime',
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
     * Contacts laisses avant une redirection vers le paiement.
     */
    public function purchaseLeads(): HasMany
    {
        return $this->hasMany(PurchaseLead::class);
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
     * Indique si la promotion est active maintenant.
     */
    public function isPromotionActive(): bool
    {
        return $this->is_promoted
            && filled($this->promotion_price)
            && $this->promotion_price > 0
            && $this->promotion_price < $this->price
            && $this->promotion_ends_at?->isFuture();
    }

    /**
     * Attribut pratique pour les vues Blade.
     */
    public function getIsOnPromotionAttribute(): bool
    {
        return $this->isPromotionActive();
    }

    /**
     * Prix actuellement affiche au visiteur.
     */
    public function getCurrentPriceAttribute(): int
    {
        return $this->isPromotionActive() ? (int) $this->promotion_price : (int) $this->price;
    }

    /**
     * Prix actuellement affiche au visiteur, format FCFA.
     */
    public function getFormattedCurrentPriceAttribute(): string
    {
        return number_format($this->current_price, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Indique si ce produit doit etre achete sur Chariow.
     */
    public function hasChariowCheckout(): bool
    {
        return filled($this->chariow_checkout_url);
    }

    /**
     * URL publique de l'image produit avec fallback si le fichier n'existe plus.
     */
    public function imageUrl(string $fallback): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        return asset($fallback);
    }
}
