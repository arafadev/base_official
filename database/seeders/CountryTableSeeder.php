<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        DB::table('countries')->insert([
			[
				'name'             => json_encode(['ar' => 'السعودية', 'en' => 'Saudi Arabia'], JSON_UNESCAPED_UNICODE),
				'image'            => 'sa.png',
				'country_code'     => '966',
				'iso2'              => 'SA',
				'iso3'              => 'SAU',
				'created_at'       => Carbon::now()->subMonths(rand(0, 6)),
			], [
				'name'             => json_encode(['ar' => 'مصر', 'en' => 'Egypt'], JSON_UNESCAPED_UNICODE),
				'image'            => 'eg.png',
				'country_code'     => '20',
				'iso2'              => 'EG',
				'iso3'              => 'EGY',
				'created_at'       => Carbon::now()->subMonths(rand(0, 6)),
			], [
				'name'             => json_encode(['ar' => 'البحرين', 'en' => 'El-Bahrean'], JSON_UNESCAPED_UNICODE),
				'image'            => 'bh.png',
				'country_code'     => '973',
				'iso2'              => 'BH',
				'iso3'              => 'BHR',
				'created_at'       => Carbon::now()->subMonths(rand(0, 6)),
			], [
				'name'             => json_encode(['ar' => 'قطر', 'en' => 'Qatar'], JSON_UNESCAPED_UNICODE),
				'image'            => 'qa.png',
				'country_code'     => '974',
				'iso2'              => 'QA',
				'iso3'              => 'QAT',
				'created_at'       => Carbon::now()->subMonths(rand(0, 6)),
			]
		]);
    }

}
