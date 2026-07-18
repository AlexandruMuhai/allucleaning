<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningJob;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isPracownik()) {
            return redirect()->route('admin.jobs.index');
        }

        if ($user->isKlient()) {
            return redirect()->route('admin.locations.index');
        }

        $jobs = CleaningJob::with(['location', 'employee'])
            ->where('status', CleaningJob::STATUS_COMPLETED)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(20)
            ->get();

        return view('admin.dashboard', compact('jobs'));
    }
}
