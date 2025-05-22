<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

class UserQuery
{
    public function me($_, array $args)
    {
        return Auth::user();
    }
}
