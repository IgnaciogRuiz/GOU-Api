<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatStoreRequest;
use App\Http\Requests\ChatUpdateRequest;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chats = Chat::all();

        return new ChatCollection($chats);
    }

    public function store(ChatStoreRequest $request)
    {
        $chat = Chat::create($request->validated());

        return new ChatResource($chat);
    }

    public function show(Request $request, Chat $chat)
    {
        return new ChatResource($chat);
    }

    public function update(ChatUpdateRequest $request, Chat $chat)
    {
        $chat->update($request->validated());

        return new ChatResource($chat);
    }

    public function destroy(Request $request, Chat $chat)
    {
        $chat->delete();

        return response()->noContent();
    }
}
