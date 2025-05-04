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
                'guest_donor_id' => null,
                'amount' => $faker->randomFloat(2, 10, 1000),
                'currency' => 'USD',
                'notes' => $faker->optional()->sentence,
                'payment_method' => $faker->randomElement(['credit_card','paypal','bank_transfer','apple_pay','google_pay']),
                'payment_status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'payment_reference' => $faker->uuid,
                'paypal_transaction_id' => null,
                'card_brand' => $faker->creditCardType,
                'card_last_four' => substr($faker->creditCardNumber, -4),
            ]);
        }
    }
}
