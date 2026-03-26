<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@codesommet.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('CodesommetAdmin2026!'),
                'is_super_admin' => true,
            ]
        );
    }
}
