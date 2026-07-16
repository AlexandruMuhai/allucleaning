<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QrPassport;
use Illuminate\Auth\Access\HandlesAuthorization;

class QrPassportPolicy
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
        return $user->isPracownik() || $user->isKlient();
    }

    public function view(User $user, QrPassport $qrPassport): bool
    {
        $location = $qrPassport->location;

        if ($user->isKlient()) {
            return $location && $location->client_id === $user->id;
        }

        if ($user->isPracownik()) {
            return $user->locations()->where('location_id', $qrPassport->location_id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, QrPassport $qrPassport): bool
    {
        return false;
    }

    public function delete(User $user, QrPassport $qrPassport): bool
    {
        return false;
    }
}
