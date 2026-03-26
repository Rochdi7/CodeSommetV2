<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tech_stack' => 'array',
        'phases' => 'array',
        'start_date' => 'date',
        'deadline' => 'date',
        'launched_at' => 'date',
        'completed_at' => 'date',
        'quoted_price' => 'decimal:2',
        'agreed_price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->name);
            }
        });
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

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

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'lead' => 'Lead',
            'proposal' => 'Proposition',
            'negotiation' => 'Négociation',
            'contracted' => 'Sous contrat',
            'discovery' => 'Découverte',
            'design' => 'Design',
            'development' => 'Développement',
            'testing' => 'Test & QA',
            'review' => 'Revue client',
            'launched' => 'Lancé',
            'maintenance' => 'Maintenance',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            'on_hold' => 'En pause',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'lead', 'proposal', 'negotiation' => '#F59E0B',
            'contracted', 'discovery' => '#00AEEF',
            'design', 'development', 'testing', 'review' => '#7D53FF',
            'launched', 'completed' => '#22C55E',
            'cancelled' => '#EF4444',
            'on_hold' => '#6B7280',
            'maintenance' => '#0EA5E9',
            default => '#6B7280',
        };
    }
}
