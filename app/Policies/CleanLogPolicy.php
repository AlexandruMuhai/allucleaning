<?php

namespace App\Policies;

use App\Models\CleanLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CleanLogPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->isPracownik();
    }

    public function view(User $user, CleanLog $cleanLog): bool
    {
        if ($user->isPracownik()) {
            if ($cleanLog->user_id === $user->id) {
                return true;
            }

            return $cleanLog->location_id
                && $user->locations()->where('location_id', $cleanLog->location_id)->exists();
        }

        return false;
    }
}
