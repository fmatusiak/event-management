<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BasicRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
