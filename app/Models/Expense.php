<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount'       => 'decimal:2',
        'expense_date' => 'date',
        'is_recurring' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        if ($this->category === 'other' && $this->category_custom) {
            return $this->category_custom;
        }
        return match ($this->category) {
            'hosting'      => 'Hébergement',
            'domain'       => 'Nom de domaine',
            'license'      => 'Licence',
            'software'     => 'Logiciel',
            'freelancer'   => 'Freelance',
            'ads'          => 'Publicité',
            'tools'        => 'Outils',
            'hardware'     => 'Matériel',
            'office'       => 'Bureau',
            'travel'       => 'Déplacement',
            'marketing'    => 'Marketing',
            'design_asset' => 'Asset design',
            'api_service'  => 'Service API',
            'abonnement'   => 'Abonnement',
            'other'        => 'Autre',
            default        => $this->category,
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'hosting', 'domain'              => '#00AEEF',
            'license', 'software', 'tools'   => '#7D53FF',
            'freelancer'                     => '#F59E0B',
            'ads', 'marketing'               => '#EF4444',
            'hardware', 'office'             => '#6B7280',
            'travel'                         => '#0EA5E9',
            'design_asset'                   => '#EC4899',
            'api_service'                    => '#14B8A6',
            'abonnement'                     => '#8B5CF6',
            default                          => '#6B7280',
        };
    }
}
