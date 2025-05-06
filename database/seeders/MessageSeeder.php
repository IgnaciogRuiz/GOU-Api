<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $chats = Chat::all();
        $users = User::pluck('id')->toArray();

        foreach ($chats as $chat) {
            for ($i = 0; $i < rand(5, 15); $i++) {
                $senderId = fake()->randomElement([$chat->user1_id, $chat->user2_id]);

                Message::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $senderId,
                    'message' => fake()->sentence(),
                    'sent_date' => now()->subMinutes(rand(1, 1000)),
                    'status' => fake()->randomElement(["sent", "read"]),
                    'user_id' => $senderId, // si el modelo lo requiere
                ]);
            }
        }
    }
}

