<?php

namespace Database\Seeders;

use App\Models\HomeAd;
use Illuminate\Database\Seeder;

class HomeAdSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            [
                'slot'       => 1,
                'title'      => 'Bannière 1 (Carré)',
                'alt_text'   => 'Pikasso Studio — Offre Spéciale',
                'link_url'   => '#',
                'image_path' => null,
                'is_active'  => true,
            ],
            [
                'slot'       => 2,
                'title'      => 'Bannière 2 (Carré)',
                'alt_text'   => 'Pikasso Studio — Nos Services',
                'link_url'   => '#',
                'image_path' => null,
                'is_active'  => true,
            ],
            [
                'slot'       => 3,
                'title'      => 'Bannière 3 (Rectangle)',
                'alt_text'   => 'Pikasso Studio — Promotion',
                'link_url'   => '#',
                'image_path' => null,
                'is_active'  => true,
            ],
        ];

        foreach ($ads as $data) {
            HomeAd::updateOrCreate(['slot' => $data['slot']], $data);
        }
    }
}
