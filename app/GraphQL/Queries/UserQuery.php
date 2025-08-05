<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserQuery
{
    public function me($_, array $args)
    {
        return Auth::user();
    }
    public function userPhoto(User $user)
    {
        return $user->profile_photo;
    }
}
