<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Campagne;

class CampagnePolicy
{
    public function view(User $user, Campagne $campagne)
    {
        return $user->id === $campagne->user_id;
    }

    public function update(User $user, Campagne $campagne)
    {
        return $user->id === $campagne->user_id;
    }

    public function delete(User $user, Campagne $campagne)
    {
        return $user->id === $campagne->user_id;
    }
}
