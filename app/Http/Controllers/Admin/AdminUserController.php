<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\CleaningJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $completedJobs = CleaningJob::with('location')
            ->where('employee_id', $user->id)
            ->where('status', CleaningJob::STATUS_COMPLETED)
            ->whereNotNull('started_at')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(50)
            ->get();

        $totalHours = $completedJobs->sum('duration_minutes') / 60;
        $totalEarnings = $completedJobs->sum('earnings');

        $currentWeekJobs = CleaningJob::with('location')
            ->where('employee_id', $user->id)
            ->whereBetween('scheduled_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();

        $assignedLocations = $user->locations()->withCount('cleaningJobs')->get();

        return view('admin.users.show', compact(
            'user',
            'completedJobs',
            'totalHours',
            'totalEarnings',
            'currentWeekJobs',
            'assignedLocations',
        ));
    }

    public function create(): View
    {
        $roles = Role::cases();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:' . implode(',', array_column(Role::cases(), 'value'))],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'krk_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'hourly_rate' => $validated['hourly_rate'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employee-photos', 'public');
        }

        if ($request->hasFile('krk_document')) {
            $data['krk_document_path'] = $request->file('krk_document')->store('krk-documents', 'public');
            $data['krk_verified'] = true;
            $data['krk_verified_at'] = now();
        }

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Użytkownik został utworzony.');
    }

    public function edit(User $user): View
    {
        $roles = Role::cases();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:' . implode(',', array_column(Role::cases(), 'value'))],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'krk_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'krk_verified' => ['sometimes', 'boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->hourly_rate = $validated['hourly_rate'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('employee-photos', 'public');
        }

        if ($request->hasFile('krk_document')) {
            $user->krk_document_path = $request->file('krk_document')->store('krk-documents', 'public');
            $user->krk_verified = true;
            $user->krk_verified_at = now();
        }

        if (isset($validated['krk_verified'])) {
            $user->krk_verified = (bool) $validated['krk_verified'];
            if (! $user->krk_verified) {
                $user->krk_verified_at = null;
            }
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Użytkownik został zaktualizowany.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['delete' => 'Nie możesz usunąć własnego konta.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Użytkownik został usunięty.');
    }
}
