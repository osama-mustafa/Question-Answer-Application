<?php

namespace Tests\Feature\Traits;

use App\Models\User;


trait CreateUserTrait
{
    public function createUserForTesting($attributes = [])
    {
        return User::factory()->create($attributes);
    }
}
