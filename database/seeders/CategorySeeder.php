<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Default blog categories with their badge colours.
     */
    private array $categories = [
        ['Général',              'general',         '#6B7280'],
        ['Développement Web',    'web-development', '#00AEEF'],
        ['Design & UX',          'design',          '#EC4899'],
        ['SEO & Marketing',      'seo',             '#22C55E'],
        ['Technologie',          'technology',      '#7D53FF'],
        ['Business & Stratégie', 'business',        '#F59E0B'],
        ['Tutoriels',            'tutorials',       '#14B8A6'],
        ['Études de cas',        'case-studies',    '#0EA5E9'],
        ['Actualités',           'news',            '#EF4444'],
    ];

    public function run(): void
    {
        foreach ($this->categories as [$name, $slug, $color]) {
            Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'color' => $color]
            );
        }
    }
}
