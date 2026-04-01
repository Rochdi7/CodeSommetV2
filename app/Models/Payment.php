<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount'         => 'decimal:2',
        'partial_amount' => 'decimal:2',
        'due_date'       => 'date',
        'paid_at'        => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // ─── Partial payment helpers ──────────────────────────────────────────────

    /** Amount still owed (for partial payments) */
    public function getRemainingAmountAttribute(): float
    {
        if ($this->payment_mode !== 'partial' || $this->partial_amount === null) {
            return 0;
        }
        return max(0, (float) $this->amount - (float) $this->partial_amount);
    }

    public function isPartial(): bool
    {
        return $this->payment_mode === 'partial';
    }

    // ─── Labels ───────────────────────────────────────────────────────────────

    public function getModeLabelAttribute(): string
    {
        return $this->payment_mode === 'partial' ? 'Partiel' : 'Complet';
    }

    public function getModeColorAttribute(): string
    {
        return $this->payment_mode === 'partial' ? '#F59E0B' : '#22C55E';
    }

    /**
     * Payment types — natural French labels for a web dev agency.
     *
     * Slugs kept for backward compatibility with existing rows.
     * New slugs: acompte, versement, solde_final, mensualite, extra, remboursement
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'acompte', 'deposit'    => 'Acompte',
            'versement', 'milestone'=> 'Versement',
            'solde_final', 'final'  => 'Solde final',
            'mensualite','maintenance'=> 'Mensualité',
            'extra'                 => 'Extra',
            'remboursement','refund'=> 'Remboursement',
            null, ''                => 'Paiement',
            default                 => ucfirst($this->type ?? ''),
        };
    }

    /** Human-readable period label (e.g. "Mars 2026", "T2 2026", "2026") */
    public function getPeriodLabelAttribute(): string
    {
        if (! $this->billing_period) return '—';

        // Quarterly: "2026-Q1"
        if (preg_match('/^(\d{4})-(Q\d)$/', $this->billing_period, $m)) {
            return 'T'.substr($m[2], 1).' '.$m[1];
        }

        // Monthly: "2026-03"
        if (preg_match('/^(\d{4})-(\d{2})$/', $this->billing_period, $m)) {
            $months = ['','Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
            return ($months[(int) $m[2]] ?? $m[2]).' '.$m[1];
        }

        // Annual: "2026"
        return $this->billing_period;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'En attente',
            'paid'      => 'Payé',
            'partial'   => 'Partiel',
            'overdue'   => 'En retard',
            'cancelled' => 'Annulé',
            'refunded'  => 'Remboursé',
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid'      => '#22C55E',
            'partial'   => '#F59E0B',
            'pending'   => '#94A3B8',
            'overdue'   => '#EF4444',
            'cancelled' => '#6B7280',
            'refunded'  => '#7D53FF',
            default     => '#6B7280',
        };
    }

    public function getMethodLabelAttribute(): string
    {
        if ($this->method === 'other' && $this->method_custom) {
            return $this->method_custom;
        }
        return match ($this->method) {
            'cash'          => 'Espèces',
            'bank_transfer' => 'Virement',
            'cheque'        => 'Chèque',
            'paypal'        => 'PayPal',
            'stripe'        => 'Stripe',
            'wise'          => 'Wise',
            'crypto'        => 'Crypto',
            'other'         => 'Autre',
            default         => $this->method ?? '—',
        };
    }
}
