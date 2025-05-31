<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Chat;
use App\Models\User;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final readonly class ChatQuery
{
    public function lastMessage(Chat $chat)
    {
        return $chat->messages()->latest()->first();
    }
    public function userChats(User $user)
    {
        return Chat::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['messages' => function ($query) {
                $query->latest();
            }])
            ->withCount('messages')
            ->get()
            ->sortByDesc(function ($chat) {
                return optional($chat->messages->last())->created_at;
            })
            ->values();
    }
    public function otherUser(Chat $chat, array $args, GraphQLContext $context)
    {
        $authUser = $context->user();

        if ($chat->user1_id === $authUser->id) {
            return $chat->user2;
        }

        return $chat->user1;
    }
}
