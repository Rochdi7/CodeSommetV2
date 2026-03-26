<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'deposit' => 'Acompte',
            'milestone' => 'Jalon',
            'final' => 'Solde final',
            'maintenance' => 'Maintenance',
            'extra' => 'Extra',
            'refund' => 'Remboursement',
            default => $this->type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'paid' => 'Payé',
            'overdue' => 'En retard',
            'cancelled' => 'Annulé',
            'refunded' => 'Remboursé',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid' => '#22C55E',
            'pending' => '#F59E0B',
            'overdue' => '#EF4444',
            'cancelled' => '#6B7280',
            'refunded' => '#7D53FF',
            default => '#6B7280',
        };
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'bank_transfer' => 'Virement bancaire',
            'paypal' => 'PayPal',
            'stripe' => 'Stripe',
            'cash' => 'Espèces',
            'wise' => 'Wise',
            'crypto' => 'Crypto',
            'other' => 'Autre',
            default => $this->method,
        };
    }
}
