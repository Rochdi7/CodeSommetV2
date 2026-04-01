<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetEntry extends Model
{
    protected $table = 'personal_budget_entries';

    protected $fillable = [
        'entry_date',
        'category',
        'category_label',
        'amount',
        'note',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'amount'     => 'decimal:2',
    ];

    public static array $categories = [
        'essence'    => ['label' => 'Essence',      'icon' => '⛽'],
        'coffre'     => ['label' => 'Coffre',        'icon' => '🔐'],
        'repas'      => ['label' => 'Repas',         'icon' => '🍽️'],
        'snacks'     => ['label' => 'Snacks',        'icon' => '🍿'],
        'cafe'       => ['label' => 'Café',          'icon' => '☕'],
        'transport'  => ['label' => 'Transport',     'icon' => '🚗'],
        'parking'    => ['label' => 'Parking',       'icon' => '🅿️'],
        'courses'    => ['label' => 'Courses',       'icon' => '🛒'],
        'pharmacie'  => ['label' => 'Pharmacie',     'icon' => '💊'],
        'telephone'  => ['label' => 'Téléphone',     'icon' => '📱'],
        'internet'   => ['label' => 'Internet',      'icon' => '🌐'],
        'loisirs'    => ['label' => 'Loisirs',       'icon' => '🎬'],
        'sport'      => ['label' => 'Sport',         'icon' => '🏋️'],
        'coiffeur'   => ['label' => 'Coiffeur',      'icon' => '✂️'],
        'cadeau'     => ['label' => 'Cadeau',        'icon' => '🎁'],
        'restaurant' => ['label' => 'Restaurant',    'icon' => '🍕'],
        'factures'   => ['label' => 'Factures',      'icon' => '💡'],
        'vetements'  => ['label' => 'Vêtements',     'icon' => '👕'],
        'autre'      => ['label' => 'Autre',         'icon' => '➕'],
    ];

    public function getCategoryLabelAttribute(): string
    {
        if ($this->category === 'autre' && $this->category_label) {
            return $this->category_label;
        }
        return static::$categories[$this->category]['label'] ?? $this->category;
    }

    public function getCategoryIconAttribute(): string
    {
        return static::$categories[$this->category]['icon'] ?? '💰';
    }
}
