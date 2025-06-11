<?php

namespace App\GraphQL\Mutations;

use App\Events\NewMessageSent;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageResolver
{
    public function createMessage($_, array $args)
    {
        $message = Message::create([
            'chat_id' => $args['chat_id'],
            'sender_id' => $args['sender_id'],
            'message' => $args['message'],
            'status' => $args['status'],
        ]);

        broadcast(new NewMessageSent($message))->toOthers();
        Log::info('Evento enviado con ID: ' . $message->id);

        return $message;
    }
}
