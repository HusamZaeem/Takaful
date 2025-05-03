<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $faker = Faker::create();

        for($i = 0; $i < 20; $i++) {
            User::create([
                'first_name'        => $faker->firstName,
                'father_name'       => $faker->firstName,
                'grandfather_name'  => $faker->firstName,
                'last_name'         => $faker->lastName,
                'email'             => $faker->unique()->safeEmail,
                'password'          => bcrypt('password'),
                'phone'             => $faker->phoneNumber,
                'gender'            => $faker->randomElement(['male', 'female']),
                'date_of_birth'     => $faker->date(),
                'nationality'       => $faker->country,
                'id_number'         => $faker->numerify('##########'),
                'marital_status'    => $faker->randomElement(['single', 'married']),
                'residence_place'   => $faker->city,
                'street_name'       => $faker->streetName,
                'building_number'   => $faker->buildingNumber,
                'city'              => $faker->city,
                'ZIP'               => $faker->postcode,
                'profile_picture'   => $faker->imageUrl(200, 200, 'people', true),
            ]);
        }
    }
}
