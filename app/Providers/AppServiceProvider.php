<?php

namespace App\Providers;

use App\Models\CleaningJob;
use App\Models\IssueReport;
use App\Models\Location;
use App\Models\QrPassport;
use App\Policies\CleanLogPolicy;
use App\Policies\CleaningJobPolicy;
use App\Policies\IssueReportPolicy;
use App\Policies\LocationPolicy;
use App\Policies\QrPassportPolicy;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Location::class => LocationPolicy::class,
        QrPassport::class => QrPassportPolicy::class,
        CleanLog::class => CleanLogPolicy::class,
        IssueReport::class => IssueReportPolicy::class,
        CleaningJob::class => CleaningJobPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', fn ($user) => $user->isAdministrator());
        Gate::define('employee', fn ($user) => $user->isPracownik());
        Gate::define('client', fn ($user) => $user->isKlient());
    }
}
