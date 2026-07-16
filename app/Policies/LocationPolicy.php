<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
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

    public function view(User $user, Location $location): bool
    {
        if ($user->isKlient()) {
            return $location->client_id === $user->id;
        }

        if ($user->isPracownik()) {
            // pracownik widzi lokalizacje do których jest przypisany
            return $user->locations()->where('location_id', $location->id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return false; // tylko admin
    }

    public function update(User $user, Location $location): bool
    {
        return false;
    }

    public function delete(User $user, Location $location): bool
    {
        return false;
    }

    /**
     * Czy pracownik może odczytać wrażliwe dane (access_code, cleaning_instructions).
     * Tylko w dniu zaplanowanego sprzątania (schedule_info) — uproszczona logika:
     * gdy lokalizacja przypisana pracownikowi i jest aktywna.
     */
    public function viewSensitive(User $user, Location $location): bool
    {
        if (! $user->isPracownik()) {
            return false;
        }

        return $user->locations()->where('location_id', $location->id)->exists()
            && $location->is_active;
    }
}
