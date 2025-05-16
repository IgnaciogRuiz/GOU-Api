<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\MessageUpdateRequest;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    /**
     * Show All Message
     * 
     * Muestra Todos los mensajes de un usuario y chat especifico. 
     */
    public function index(Request $request)
    {
        $messages = Message::all();

        return new MessageCollection($messages);
    }

    /**
     * Create Message  
     * 
     * Crea un mensaje de un usuario y chat especifico. 
     */
    public function store(MessageStoreRequest $request)
    {
        $message = Message::create($request->validated());

        return new MessageResource($message);
    }

    /**
     * Show Message 
     * 
     * Muestra un mensaje de un usuario y chat especifico.(no se va a utilizar). Usar 
     * @deprecated 
     */
    public function show(Request $request, Message $message)
    {
        return new MessageResource($message);
    }

    /**
     * Update Message  
     * 
     * Actualiza un mensaje de un usuario y chat especifico. 
     */
    public function update(MessageUpdateRequest $request, Message $message)
    {
        $message->update($request->validated());

        return new MessageResource($message);
    }

    public function destroy(Request $request, Message $message)
    {
        $message->delete();

        return response()->noContent();
    }
}
