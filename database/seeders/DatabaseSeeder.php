<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ComplaintTableSeeder::class);



        $this->command->info('Starting sync:crud command...');
        Artisan::call('sync:crud');
        $this->command->info('sync:crud command completed successfully.');
    }
}
