<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningJob;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CleaningJobController extends Controller
{
    /**
     * Podgląd zleceń (admin: wszystkie; pracownik: swoje na dziś)
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isAdministrator()) {
            return $this->adminIndex();
        }

        return $this->employeeIndex($user);
    }

    private function adminIndex(): View
    {
        $dateFrom = request()->query('date_from', Carbon::today()->toDateString());
        $dateTo = request()->query('date_to', Carbon::today()->addDays(7)->toDateString());

        $jobs = CleaningJob::with(['location', 'employee'])
            ->whereBetween('scheduled_date', [$dateFrom, $dateTo])
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->paginate(30)
            ->withQueryString();

        $employees = User::where('role', 'pracownik')->orderBy('name')->get();

        return view('admin.jobs.index', compact('jobs', 'employees', 'dateFrom', 'dateTo'));
    }

    private function employeeIndex(User $user): View
    {
        $today = Carbon::today()->toDateString();

        $jobs = CleaningJob::with(['location'])
            ->where('employee_id', $user->id)
            ->where('scheduled_date', $today)
            ->whereIn('status', [CleaningJob::STATUS_PENDING, CleaningJob::STATUS_IN_PROGRESS])
            ->orderBy('scheduled_time')
            ->get();

        return view('admin.jobs.employee-index', compact('jobs', 'today'));
    }

    /**
     * Widok szczegółów zlecenia
     */
    public function show(CleaningJob $job): View
    {
        $user = auth()->user();

        if ($user->isPracownik()) {
            if ($job->employee_id !== $user->id) {
                abort(403);
            }

            $job->load('location');

            return view('admin.jobs.employee-show', compact('job'));
        }

        $job->load(['location', 'employee']);

        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Podgląd zlecenia przez pracownika (szczegóły lokalizacji)
     */
    public function showForEmployee(CleaningJob $job): View
    {
        $this->authorize('view', $job);

        $job->load('location');

        return view('admin.jobs.employee-show', compact('job'));
    }

    /**
     * Admin: przypisanie pracownika (zastępstwo)
     */
    public function reassign(Request $request, CleaningJob $job): RedirectResponse
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:users,id'],
        ]);

        $job->update(['employee_id' => $data['employee_id']]);

        return back()->with('success', 'Pracownik został przypisany do zlecenia.');
    }

    /**
     * Admin: zmiana statusu
     */
    public function updateStatus(Request $request, CleaningJob $job): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:pending,in_progress,completed,cancelled'],
        ]);

        $updates = ['status' => $data['status']];

        if ($data['status'] === CleaningJob::STATUS_COMPLETED) {
            $updates['completed_at'] = now();
        }

        $job->update($updates);

        return back()->with('success', 'Status zlecenia został zmieniony.');
    }

    /**
     * Pracownik: rozpoczęcie zlecenia
     */
    public function start(CleaningJob $job): RedirectResponse
    {
        $this->authorize('view', $job);

        if (! $job->isPending()) {
            return back()->with('error', 'To zlecenie nie może zostać rozpoczęte.');
        }

        $job->update([
            'status' => CleaningJob::STATUS_IN_PROGRESS,
            'started_at' => now(),
        ]);

        return back()->with('success', 'Zlecenie rozpoczęte.');
    }

    /**
     * Pracownik: zakończenie zlecenia
     */
    public function complete(Request $request, CleaningJob $job): RedirectResponse
    {
        $this->authorize('view', $job);

        if (! $job->isInProgress()) {
            return back()->with('error', 'To zlecenie nie jest w trakcie realizacji.');
        }

        $data = $request->validate([
            'photo' => ['nullable', 'image', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('job-photos', 'public');
        }

        $job->update([
            'status' => CleaningJob::STATUS_COMPLETED,
            'completed_at' => now(),
            'photo_path' => $photoPath,
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('success', 'Zlecenie zostało oznaczone jako ukończone.');
    }
}
