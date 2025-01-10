<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::insert([
			['key' => 'name_ar', 'value' => 'المشروع'],
			['key' => 'name_en', 'value' => 'Project'],
			['key' => 'email', 'value' => 'admin@info.com'],
			['key' => 'phone', 'value' => '+96650123456'],
			['key' => 'whatsapp', 'value' => '+96650123456'],
			// ['key' => 'logo', 'value' => 'logo.png'],
			// ['key' => 'fav_icon', 'value' => 'fav_icon.png'],
			['key' => 'address', 'value' => 'السعودية'],
			['key' => 'vat', 'value' => '15'],
			['key' => 'admin_percentage', 'value' => '10'],
        ]);
    }
}

