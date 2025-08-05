<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Aquí puedes registrar todos los canales de broadcasting que tu
| aplicación soporta. El callback de autorización se utiliza para
| verificar si un usuario autenticado puede escuchar el canal.
|
*/



Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = \App\Models\Chat::find($chatId);
    return $chat && (
        $chat->user1_id === $user->id ||
        $chat->user2_id === $user->id
    );
});
