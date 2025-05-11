<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CaseForm;
use App\Models\User;
use Faker\Factory as Faker;
use Users as GlobalUsers;

class CaseFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        
        $faker = Faker::create();
        $users = User::take(10)->get();

        foreach ($users as $user) {

            for ($i = 0; $i < rand(1, 2); $i++) {
                
                CaseForm::create([
                    'user_id' => $user->user_id,
                    'incident_date' => $faker->date(),
                    'short_description' => $faker->sentence(10),
                    'notes' => $faker->optional()->paragraph,
                    'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                    'admin_note' => $faker->optional()->sentence,
                ]);

            }
            

        }

        
    }
}
