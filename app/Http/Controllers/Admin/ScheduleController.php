<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningJob;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(): View
    {
        $employees = User::where('role', 'pracownik')
            ->with('locations')
            ->orderBy('name')
            ->get();

        return view('admin.schedule.index', compact('employees'));
    }

    public function events(Request $request): JsonResponse
    {
        $dateFrom = $request->query('start', Carbon::now()->startOfWeek()->toDateString());
        $dateTo = $request->query('end', Carbon::now()->endOfWeek()->toDateString());

        $jobs = CleaningJob::with(['location', 'employee'])
            ->whereBetween('scheduled_date', [$dateFrom, $dateTo])
            ->whereNotIn('status', [CleaningJob::STATUS_CANCELLED])
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();

        $now = now();

        $events = $jobs->map(function ($job) use ($now) {
            $start = $job->schedule_start;
            $end = $job->schedule_end;

            // Live status coloring
            $color = match ($job->status) {
                'in_progress' => '#f59e0b',
                'completed' => '#22c55e',
                default => '#94a3b8',
            };

            // ALARM: pending job past its start time
            if ($job->status === 'pending' && $start->lt($now)) {
                $color = '#ef4444';
            }

            return [
                'id' => $job->id,
                'resourceId' => (string) $job->employee_id,
                'title' => $job->location?->name ?? 'Bez lokalizacji',
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'color' => $color,
                'borderColor' => 'transparent',
                'extendedProps' => [
                    'jobId' => $job->id,
                    'locationId' => $job->location_id,
                    'employeeId' => $job->employee_id,
                    'status' => $job->status,
                    'statusLabel' => $job->statusLabel(),
                    'address' => $job->location?->address ?? '',
                    'scheduledDuration' => $job->scheduled_duration_minutes ?? 120,
                    'startedAt' => $job->started_at?->toIso8601String(),
                    'completedAt' => $job->completed_at?->toIso8601String(),
                ],
            ];
        });

        return response()->json($events);
    }

    public function resources(): JsonResponse
    {
        $employees = User::where('role', 'pracownik')
            ->orderBy('name')
            ->get();

        $resources = $employees->map(fn ($emp) => [
            'id' => (string) $emp->id,
            'title' => $emp->name,
            'photo' => $emp->photo_url,
            'initial' => $emp->initial,
            'hourlyRate' => $emp->hourly_rate,
        ]);

        return response()->json($resources);
    }

    public function reassign(Request $request, CleaningJob $job): JsonResponse
    {
        $this->authorize('update', $job);

        $data = $request->validate([
            'employee_id' => ['required', 'exists:users,id'],
        ]);

        $job->update(['employee_id' => $data['employee_id']]);

        return response()->json(['success' => true, 'message' => 'Pracownik został zmieniony.']);
    }

    public function updateTime(Request $request, CleaningJob $job): JsonResponse
    {
        $this->authorize('update', $job);

        $data = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after:start'],
        ]);

        $start = Carbon::parse($data['start']);
        $end = Carbon::parse($data['end']);

        $job->update([
            'scheduled_date' => $start->toDateString(),
            'scheduled_time' => $start->format('H:i:s'),
            'scheduled_duration_minutes' => $start->diffInMinutes($end),
        ]);

        return response()->json(['success' => true, 'message' => 'Czas zlecenia został zmieniony.']);
    }

    public function checkConflicts(Request $request): JsonResponse
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:users,id'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after:start'],
            'exclude_job_id' => ['nullable', 'exists:cleaning_jobs,id'],
        ]);

        $employee = User::find($data['employee_id']);
        $start = Carbon::parse($data['start']);
        $end = Carbon::parse($data['end']);
        $excludeId = $data['exclude_job_id'] ?? null;

        // 1. Time overlap check
        $overlapping = CleaningJob::with('location')
            ->where('employee_id', $employee->id)
            ->where('status', '!=', CleaningJob::STATUS_CANCELLED)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('scheduled_date', [$start->toDateString(), $end->toDateString()]);
            })
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->get()
            ->filter(function ($job) use ($start, $end) {
                $jobStart = $job->schedule_start;
                $jobEnd = $job->schedule_end;
                return $start->lt($jobEnd) && $end->gt($jobStart);
            });

        $conflicts = $overlapping->map(fn ($job) => [
            'job_id' => $job->id,
            'location' => $job->location?->name ?? '—',
            'time' => $job->scheduled_time . ' – ' . $job->schedule_end->format('H:i'),
        ]);

        // 2. Travel time check (from previous job)
        $previousJob = CleaningJob::with('location')
            ->where('employee_id', $employee->id)
            ->where('status', '!=', CleaningJob::STATUS_CANCELLED)
            ->where('scheduled_date', $start->toDateString())
            ->where('scheduled_time', '<', $start->format('H:i:s'))
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->orderBy('scheduled_time', 'desc')
            ->first();

        $travelWarning = null;
        if ($previousJob?->location?->latitude) {
            $nextLocationId = $request->input('location_id');
            $nextLocation = $nextLocationId ? Location::find($nextLocationId) : null;

            if ($nextLocation?->latitude) {
                $distance = $this->haversine(
                    $previousJob->location->latitude, $previousJob->location->longitude,
                    $nextLocation->latitude, $nextLocation->longitude
                );
                $travelMinutes = (int) ceil($distance / 500);
                $gapMinutes = (int) $previousJob->schedule_end->diffInMinutes($start);

                if ($travelMinutes > $gapMinutes) {
                    $travelWarning = [
                        'from' => $previousJob->location->name,
                        'to' => $nextLocation->name,
                        'travel_minutes' => $travelMinutes,
                        'gap_minutes' => $gapMinutes,
                        'message' => "Uwaga: Czas dojazdu między {$previousJob->location->name} a {$nextLocation->name} to ~{$travelMinutes} min. Pracownik się spóźni.",
                    ];
                }
            }
        }

        return response()->json([
            'has_conflicts' => $conflicts->isNotEmpty() || $travelWarning !== null,
            'conflicts' => $conflicts,
            'travel_warning' => $travelWarning,
        ]);
    }

    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
