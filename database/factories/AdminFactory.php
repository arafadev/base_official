<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        static $index = 2; 

        $email = "admin{$index}@gmail.com";
        $name = "Admin {$index}";
        $index++; 

        return [
            'name'         => $name,
            'email'        => $email,
            'phone'        => '55' . $this->faker->randomNumber(7, true),
            'password'     => Hash::make('123456'),
            'country_code' => '966',
        ];
    }
}
