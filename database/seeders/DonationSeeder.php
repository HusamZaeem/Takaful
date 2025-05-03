<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Donation;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::skip(10)->take(10)->get();

        foreach ($users as $user) {
            Donation::create([
                'user_id' => $user->user_id,
                'amount' => $faker->randomFloat(2, 10, 1000),
                'currency' => $faker->currencyCode,
                'notes' => $faker->optional()->sentence,
                'payment_method' => $faker->randomElement(['credit_card','paypal','bank_transfer','cash','mobile_payment']),
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'admin_note' => $faker->optional()->sentence,
            ]);
        }
    }
}
