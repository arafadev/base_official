<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Traits\UploadTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountryTableSeeder extends Seeder
{
    use UploadTrait;

    public function run()
    {
        $countries = [
            [
                'name' => 'مصر',
                'image' => 'eg.png', 
                'country_code' => '20',
                'iso2' => 'EG',
                'iso3' => 'EGY',
            ],
            [
                'name' => 'السعودية',
                'image' => 'sa.png', 
                'country_code' => '966',
                'iso2' => 'SA',
                'iso3' => 'SAU',
            ],
            [
                'name' => 'البحرين',
                'image' => 'ba.png',
                'country_code' => '973',
                'iso2' => 'BH',
                'iso3' => 'BHR',
            ],
            [
                'name' => 'قطر',
                'image' => 'ku.png',
                'country_code' => '974',
                'iso2' => 'QA',
                'iso3' => 'QAT',
            ],
        ];

        DB::table('countries')->insert($countries);
    }

}
