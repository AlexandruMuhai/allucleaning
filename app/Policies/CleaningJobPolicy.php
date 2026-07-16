<?php

namespace App\Policies;

use App\Models\CleaningJob;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CleaningJobPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isPracownik();
    }

    public function view(User $user, CleaningJob $job): bool
    {
        return $user->isPracownik() && $job->employee_id === $user->id;
    }
}
