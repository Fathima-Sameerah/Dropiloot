<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RewardCatalog;

class RewardCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RewardCatalog::create([
            'name' => 'Free Drop Boost',
            'points_required' => 50,
            'description' => 'Boost your drop visibility once',
        ]);

        RewardCatalog::create([
            'name' => 'Exclusive Badge',
            'points_required' => 100,
            'description' => 'Get a special badge for your profile',
        ]);
    }
}
