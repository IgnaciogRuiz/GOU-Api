<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();

        for ($i = 0; $i < 150; $i++) {
            // Elegimos dos usuarios distintos
            $user1 = fake()->randomElement($userIds);
            do {
                $user2 = fake()->randomElement($userIds);
            } while ($user2 === $user1);

            Chat::create([
                'user1_id' => $user1,
                'user2_id' => $user2,
            ]);
        }
    }
}
