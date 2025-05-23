<?php
namespace App\GraphQL\Resolvers;

use App\Models\Chat;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ChatQuery
{
    public function otherUser(Chat $chat, array $args, GraphQLContext $context)
    {
        $authUser = $context->user();

        if ($chat->user1_id === $authUser->id) {
            return $chat->user2;
        }

        return $chat->user1;
    }
}