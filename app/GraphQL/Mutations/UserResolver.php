<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserResolver
{
    /* public function uploadProfilePhoto($root, array $args, GraphQLContext $context)
    {
        $user = $context->user();
        $file = $args['input']['photo'];

        // Elimina foto anterior si existe
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $file->store('profile_photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        return $user;
    }*/
}
