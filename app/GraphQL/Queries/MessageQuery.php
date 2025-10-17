<?php

namespace App\GraphQL\Queries;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageQuery
{
    /**
     * Obtener mensajes de un chat
     *
     * @param  mixed  $_
     * @param  array  $args
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMessages($_, array $args)
    {
        // opcional: validar que el usuario pertenezca al chat
        // $user = Auth::user();
        // if (! $user->chats()->where('chats.id', $args['chat_id'])->exists()) {
        //     throw new \Exception('No autorizado para ver este chat');
        // }

        return Message::where('chat_id', $args['chat_id'])
            ->with(['sender'])              // ajustá al nombre real de la relación en el modelo
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
