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
     * Pracownik: rozpoczęcie zlecenia (z walidacją GPS)
     */
    public function start(Request $request, CleaningJob $job): RedirectResponse
    {
        $this->authorize('view', $job);

        if (! $job->isPending()) {
            return back()->with('error', 'To zlecenie nie może zostać rozpoczęte.');
        }

        $location = $job->location;
        $gpsData = [];

        if ($location?->latitude && $location?->longitude) {
            $data = $request->validate([
                'user_lat' => ['required', 'numeric', 'between:-90,90'],
                'user_lng' => ['required', 'numeric', 'between:-180,180'],
            ]);

            $distance = $this->haversine(
                $data['user_lat'], $data['user_lng'],
                $location->latitude, $location->longitude
            );

            if ($distance > 50) {
                return back()->withErrors([
                    'gps' => 'Jesteś za daleko od lokalizacji (' . round($distance) . ' m). Musisz być w odległości maks. 50 m.',
                ])->withInput();
            }

            $gpsData = [
                'start_latitude' => $data['user_lat'],
                'start_longitude' => $data['user_lng'],
            ];
        }

        $job->update(array_merge([
            'status' => CleaningJob::STATUS_IN_PROGRESS,
            'started_at' => now(),
        ], $gpsData));

        return back()->with('success', 'Zlecenie rozpoczęte.');
    }

    /**
     * Haversine formula — odległość w metrach między dwoma punktami GPS.
     */
    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
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
            'user_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'user_lng' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('job-photos', 'public');
        }

        $updates = [
            'status' => CleaningJob::STATUS_COMPLETED,
            'completed_at' => now(),
            'photo_path' => $photoPath,
            'notes' => $data['notes'] ?? null,
        ];

        if (! empty($data['user_lat']) && ! empty($data['user_lng'])) {
            $updates['end_latitude'] = $data['user_lat'];
            $updates['end_longitude'] = $data['user_lng'];
        }

        $job->update($updates);

        return back()->with('success', 'Zlecenie zostało oznaczone jako ukończone.');
    }
}
