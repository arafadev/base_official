<?php
namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
	public function run()
    {
        Admin::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name'         => 'Admin',
            'phone'        => '555105813',
            'password'     => Hash::make('123456'),
            'country_code' => '966',
            'role_id'      => 1,
        ]);

        Admin::factory()->count(30)->create();
    }
}
