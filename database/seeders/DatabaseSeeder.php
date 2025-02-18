<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('starting delete old images...');

            $settingsPath = storage_path('app/public');
            File::deleteDirectory($settingsPath);
            File::makeDirectory($settingsPath);

        $this->command->info('old images deleted successfully.');

        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ComplaintTableSeeder::class);
        $this->call(PaymentBrandTableSeeder::class);
        $this->call(SmsTableSeeder::class);



        $this->command->info('Starting sync:crud command...');
        Artisan::call('sync:crud');
        $this->command->info('sync:crud command completed successfully.');
    }
}
