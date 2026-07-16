<?php

namespace App\Policies;

use App\Models\IssueReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssueReportPolicy
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
        return $user->isKlient() || $user->isPracownik();
    }

    public function view(User $user, IssueReport $issueReport): bool
    {
        $locationId = $issueReport->location_id;

        if ($user->isKlient()) {
            return $locationId && $issueReport->location?->client_id === $user->id;
        }

        if ($user->isPracownik()) {
            if ($issueReport->assigned_to === $user->id) {
                return true;
            }

            return $locationId && $user->locations()->where('location_id', $locationId)->exists();
        }

        return false;
    }

    public function manage(User $user, IssueReport $issueReport): bool
    {
        return false; // tylko admin
    }

    public function resolve(User $user, IssueReport $issueReport): bool
    {
        if (! $user->isPracownik()) {
            return false;
        }

        if ($issueReport->assigned_to === $user->id) {
            return true;
        }

        return $issueReport->location_id
            && $user->locations()->where('location_id', $issueReport->location_id)->exists();
    }
}
