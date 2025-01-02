<?php
namespace Database\Seeders;
use DB;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
	public function run()
	{
		Admin::updateOrCreate([
			'name'     => 'Admin',
			'email'    => 'a@a.com',
			'phone'    => '555105813',
			'password' => Hash::make('123456'), 
			'country_code' => '966',
		]);
	
	}
}
