<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    use HasFactory;

    public const STATUS_OPEN = 'open';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_OPEN,
        self::STATUS_IN_PROGRESS,
        self::STATUS_CLOSED,
    ];

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
    ];

    /**
     * Client ayant ouvert le ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Libelle lisible du statut.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_CLOSED => 'Ferme',
            self::STATUS_IN_PROGRESS => 'En traitement',
            default => 'Ouvert',
        };
    }

    /**
     * Classes CSS de badge pour l'admin.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_CLOSED => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
            self::STATUS_IN_PROGRESS => 'bg-gold/20 text-[#805B08] ring-gold/30',
            default => 'bg-royal/10 text-royal ring-royal/10',
        };
    }
}
