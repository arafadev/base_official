<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Complaint;
use App\Models\ComplaintReplay;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ComplaintTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 20; $i++) {
            $userCount = rand(1, 5);
            $users = User::inRandomOrder()->take($userCount)->get();

            foreach ($users as $user) {
                $complaint = Complaint::create([
                    'complaint_num' => $faker->unique()->ean13,
                    'userable_type' => User::class,
                    'userable_id' => $user->id,
                    'user_name' => $faker->name,
                    'phone' => $faker->phoneNumber,
                    'email' => $faker->email,
                    'complaint' => $faker->paragraph,
                ]);

                $replayCount = rand(1, 3); 
                for ($j = 0; $j < $replayCount; $j++) {
                    ComplaintReplay::create([
                        'complaint_id' => $complaint->id,
                        'replay' => $faker->paragraph,
                        'replayer_id' => $user->id, 
                        'replayer_type' => User::class,
                    ]);
                }
            }
        }
    }
}
