<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            User::create([
                'name' => $faker->name,
                'country_code' => '966',
                'phone' => '55' . random_int(1000000, 9999999),
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'avatar' => null,
                'is_active' => $faker->boolean,
                'is_blocked' => $faker->boolean,
                'lang' => 'ar',
                'is_notify' => true,
                'code' => '123456',
                'code_expire' => $faker->dateTimeThisYear,
                // 'lat' => $faker->latitude,
                // 'lng' => $faker->longitude,
                // 'map_desc' => $faker->sentence,
                // 'wallet_balance' => $faker->randomFloat(2, 0, 1000),
            ]);
        }
    }
}
