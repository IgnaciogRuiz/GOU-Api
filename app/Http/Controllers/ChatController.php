<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatStoreRequest;
use App\Http\Requests\ChatUpdateRequest;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

#[ExcludeAllRoutesFromDocs]



class ChatController extends Controller
{
    /**
     * Show All Chats
     * 
     * Esta ruta trae todos los chats de un usuario.
     */

    public function index(Request $request)
    {
        $chats = Chat::all();

        return new ChatCollection($chats);
    }

    /**
     * Create Chat
     * 
     * Esta ruta crea un chat a partir de 2 usuario.
     */

    public function store(ChatStoreRequest $request)
    {
        $chat = Chat::create($request->validated());

        return new ChatResource($chat);
    }

    /**
     * Show Chat
     * 
     * Esta ruta nos trae un chat especifico, y sus mensajes.
     */

    public function show(Request $request, Chat $chat)
    {
        return new ChatResource($chat);
    }

    /**
     * Update Chat
     * 
     * Esta ruta actualiza la informacion del Chat. (usuarios)
     */

    public function update(ChatUpdateRequest $request, Chat $chat)
    {
        $chat->update($request->validated());

        return new ChatResource($chat);
    }

    /**
     * Delete Chat
     * 
     * Esta ruta elimina un chat especifico.
     */

    public function destroy(Request $request, Chat $chat)
    {
        $chat->delete();

        return response()->noContent();
    }
}
