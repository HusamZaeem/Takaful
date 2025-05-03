<?php

namespace Database\Seeders;

use App\Models\CaseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['home_partial_damage', 'home_total_damage', 'martyr', 'injured'];
        
        foreach ($types as $type) {
            CaseType::create([
                'name' => $type,
            ]);

        }
    }
}
