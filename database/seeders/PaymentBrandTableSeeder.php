<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB ; 
class PaymentBrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('payment_brands')->insert([
            [
                'type'      => 'VISA MASTER',
                'name'      => 'Visa',
                'image'     => 'visa.png',
                'status'    => 'active',
                'entity_id' => '8ac7a4c888028a6c018804b2aec60298',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],[
                'type'      => 'VISA MASTER',
                'name'      => 'Master',
                'image'     => 'master.png',
                'status'    => 'active',
                'entity_id' => '8ac7a4c888028a6c018804b2aec60298',
                'created_at'    => now(),
                'updated_at'    => now(),


            ],[
                'type'      => 'MADA',
                'name'      => 'Mada',
                'image'     => 'mada.png',
                'status'    => 'active',
                'entity_id' => '8ac7a4c8813de39e01813f6d969a0327',
                'created_at'    => now(),
                'updated_at'    => now(),

            ],[
                'type'      => 'STC_PAY',
                'name'      => 'STC Pay',
                'image'     => 'stc.png',
                'status'    => 'active',
                'entity_id' => '8ac7a4c7820e3114018212cddc9d1cc7',
                'created_at'    => now(),
                'updated_at'    => now(),

            ],[
                'type'      => 'APPLEPAY',
                'name'      => 'Apple Pay',
                'image'     => 'apple.png',
                'status'    => 'active',
                'entity_id' => '8ac7a4c7820e3114018212cddc9d1cc7',
                'created_at'    => now(),
                'updated_at'    => now(),

            ],
        ]);
    }
}
