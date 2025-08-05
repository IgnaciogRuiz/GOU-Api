<?php

namespace App\GraphQL\Mutations;

use App\Events\NewMessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageRead;
use App\Events\MessageDeleted;
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

        return $message;
    }

    public function updateMessage($_, array $args)
    {
        $message = Message::find($args['id']);

        if (!$message) {
            Log::error('Message not found: ID ' . $args['id']);
            throw new \Exception('Mensaje no encontrado');
        }

        // Verificar qué tipo de actualización se está realizando
        $isContentChanged = isset($args['message']) && $args['message'] !== $message->message;
        $isStatusChanged = isset($args['status']) && $args['status'] !== $message->status;
        $isMarkingAsRead = $isStatusChanged && $args['status'] === 'READ';

        // Actualizar solo los campos proporcionados
        $updateData = [];
        if (isset($args['message'])) {
            $updateData['message'] = $args['message'];
        }
        if (isset($args['status'])) {
            $updateData['status'] = $args['status'];
        }

        $message->update($updateData);

        // Disparar eventos según el tipo de cambio
        if ($isContentChanged) {
            // Solo notificar a otros usuarios (no al que editó)
            broadcast(new MessageUpdated($message))->toOthers();
            Log::info('Message content updated', ['message_id' => $message->id]);
        }

        if ($isMarkingAsRead) {
            // Notificar que el mensaje fue leído
            broadcast(new MessageRead($message));
            Log::info('Message marked as read', [
                'message_id' => $message->id,
            ]);
        }

        return $message->fresh(['user', 'chat']);
    }

    // Método específico para marcar como leído (opcional)
    public function markAsRead($_, array $args)
    {
        $message = Message::find($args['id']);

        if (!$message) {
            throw new \Exception('Mensaje no encontrado');
        }

        if ($message->status !== 'READ') {
            $message->update([
                'status' => 'READ',
                'read_at' => now()
            ]);

            broadcast(new MessageRead($message));
        }

        return $message->fresh(['user', 'chat']);
    }

    public function deleteMessage($_, array $args)
    {
        $message = Message::find($args['id']);

        if (!$message) {
            Log::error('Message not found: ID ' . $args['id']);
            throw new \Exception('Mensaje no encontrado');
        }

        // Disparar evento de eliminación
        broadcast(new MessageDeleted($message))->toOthers();

        // Eliminar el mensaje
        $message->delete();

        return true;
    }
}
