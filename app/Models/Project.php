<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tech_stack'   => 'array',
        'phases'       => 'array',
        'start_date'   => 'date',
        'deadline'     => 'date',
        'launched_at'  => 'date',
        'completed_at' => 'date',
        'quoted_price' => 'decimal:2',
        'agreed_price' => 'decimal:2',
        'tva_percent'  => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->name);
            }
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    // ─── Financial Accessors ─────────────────────────────────────────────────

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->where('status', 'paid')->sum('amount');
    }

    public function getTotalPendingAttribute(): float
    {
        return (float) $this->payments()->where('status', 'pending')->sum('amount');
    }

    public function getRemainingBalanceAttribute(): float
    {
        return (float) $this->agreed_price - $this->total_paid;
    }

    public function getTotalExpensesAttribute(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public function getProfitAttribute(): float
    {
        return $this->total_paid - $this->total_expenses;
    }

    /**
     * agreed_price is TTC (what client pays).
     * HT = TTC / (1 + tva/100) — the net amount kept after paying TVA to govt.
     */
    public function getPriceHtAttribute(): float
    {
        if ($this->tva_percent <= 0) return (float) $this->agreed_price;
        return (float) $this->agreed_price / (1 + $this->tva_percent / 100);
    }

    /** TVA portion extracted from TTC: TTC - HT */
    public function getTvaAmountAttribute(): float
    {
        return (float) $this->agreed_price - $this->price_ht;
    }

    /** Alias so existing code using price_ttc still works */
    public function getPriceTtcAttribute(): float
    {
        return (float) $this->agreed_price;
    }

    // ─── Schedule / Health Accessors ─────────────────────────────────────────

    /** Days remaining until deadline (negative = overdue) */
    public function getDaysToDeadlineAttribute(): ?int
    {
        if (! $this->deadline) return null;
        return (int) now()->diffInDays($this->deadline, false);
    }

    /** green | yellow | red | gray */
    public function getHealthScoreAttribute(): string
    {
        if (in_array($this->status, ['cancelled'])) return 'gray';
        if ($this->status === 'on_hold') return 'gray';
        if (in_array($this->status, ['completed', 'launched'])) return 'green';

        $days = $this->days_to_deadline;
        if ($days !== null && $days < 0)  return 'red';
        if ($days !== null && $days < 7)  return 'yellow';

        return 'green';
    }

    public function getHealthColorAttribute(): string
    {
        return match ($this->health_score) {
            'red'    => '#EF4444',
            'yellow' => '#F59E0B',
            'gray'   => '#9CA3AF',
            default  => '#22C55E',
        };
    }

    // ─── Label Accessors ─────────────────────────────────────────────────────

    public function getTypeLabelAttribute(): string
    {
        if ($this->type === 'other' && $this->type_custom) {
            return $this->type_custom;
        }
        return match ($this->type) {
            'website'      => 'Site Web',
            'ecommerce'    => 'E-commerce',
            'webapp'       => 'Application Web',
            'saas'         => 'SaaS',
            'dashboard'    => 'Dashboard',
            'mobile_app'   => 'App Mobile',
            'landing_page' => 'Landing Page',
            'redesign'     => 'Refonte',
            'maintenance'  => 'Maintenance',
            'seo'          => 'SEO',
            'other'        => 'Autre',
            default        => $this->type,
        };
    }

    public function getBillingLabelAttribute(): string
    {
        if ($this->billing_type !== 'recurring') return 'Projet unique';
        return match ($this->recurring_period) {
            'monthly'    => '↻ Mensuel',
            'quarterly'  => '↻ Trimestriel',
            'annually'   => '↻ Annuel',
            default      => '↻ Récurrent',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'lead'        => 'Lead',
            'proposal'    => 'Proposition',
            'negotiation' => 'Négociation',
            'contracted'  => 'Sous contrat',
            'discovery'   => 'Découverte',
            'design'      => 'Design',
            'development' => 'Développement',
            'testing'     => 'Test & QA',
            'review'      => 'Revue client',
            'launched'    => 'Lancé',
            'maintenance' => 'Maintenance',
            'completed'   => 'Terminé',
            'cancelled'   => 'Annulé',
            'on_hold'     => 'En pause',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'lead', 'proposal', 'negotiation'              => '#F59E0B',
            'contracted', 'discovery'                      => '#00AEEF',
            'design', 'development', 'testing', 'review'  => '#7D53FF',
            'launched', 'completed'                        => '#22C55E',
            'cancelled'                                    => '#EF4444',
            'on_hold'                                      => '#6B7280',
            'maintenance'                                  => '#0EA5E9',
            default                                        => '#6B7280',
        };
    }
}
