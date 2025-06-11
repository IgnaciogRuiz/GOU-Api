<?php

use Illuminate\Support\Facades\Broadcast;

//Broadcast::channel('test-channel', function ($user) {
//    return true; // para pruebas, dejalo abierto
//});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = \App\Models\Chat::find($chatId);
    return $chat && ($chat->user1_id === $user->id || $chat->user2_id === $user->id);
});
