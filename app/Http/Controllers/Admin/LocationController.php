<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $query = Location::with(['client', 'passports'])
            ->withCount('passports');

        if ($user->isKlient()) {
            $query->where('client_id', $user->id);
        } elseif ($user->isPracownik()) {
            $query->where('is_active', true)
                ->whereHas('employees', fn ($q) => $q->where('user_id', $user->id));
        }

        $locations = $query->latest()->paginate(15);

        $view = match (true) {
            $user->isPracownik() => 'admin.locations.index-employee',
            $user->isKlient() => 'admin.locations.index-client',
            default => 'admin.locations.index',
        };

        return view($view, compact('locations'));
    }

    public function show(Location $location): View
    {
        $this->authorize('view', $location);

        $user = auth()->user();

        $view = match (true) {
            $user->isPracownik() => 'admin.locations.show-employee',
            $user->isKlient() => 'admin.locations.show-client',
            default => 'admin.locations.show',
        };

        $location->load(['passports.zone_name', 'cleanLogs' => fn ($q) => $q->latest('cleaned_at')->limit(10)->with('user'), 'issueReports' => fn ($q) => $q->latest()->limit(10)]);

        return view($view, compact('location'));
    }

    public function create(): View
    {
        $clients = User::where('role', 'klient')->orderBy('name')->get();
        $employees = User::where('role', 'pracownik')->orderBy('name')->get();

        return view('admin.locations.create', compact('clients', 'employees'));
    }

    public function store(\Illuminate\Http\Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['nullable', 'exists:users,id'],
            'type' => ['required', 'string', 'in:office,staircase'],
            'address' => ['required', 'string', 'max:1000'],
            'area_sqm' => ['nullable', 'integer', 'min:1'],
            'access_code' => ['nullable', 'string', 'max:500'],
            'cleaning_instructions' => ['nullable', 'string', 'max:5000'],
            'schedule_info' => ['nullable', 'string', 'max:255'],
            'employees' => ['nullable', 'array'],
            'employees.*' => ['exists:users,id'],
        ]);

        $location = Location::create(array_merge($data, [
            'uuid' => \Illuminate\Support\Str::uuid(),
        ]));

        if (! empty($data['employees'])) {
            $location->employees()->sync($data['employees']);
        }

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Obiekt został utworzony.');
    }

    public function edit(Location $location): View
    {
        $this->authorize('update', $location);

        $clients = User::where('role', 'klient')->orderBy('name')->get();
        $employees = User::where('role', 'pracownik')->orderBy('name')->get();
        $assigned = $location->employees()->pluck('user_id')->toArray();

        return view('admin.locations.edit', compact('location', 'clients', 'employees', 'assigned'));
    }

    public function update(\Illuminate\Http\Request $request, Location $location): RedirectResponse
    {
        $this->authorize('update', $location);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['nullable', 'exists:users,id'],
            'type' => ['required', 'string', 'in:office,staircase'],
            'address' => ['required', 'string', 'max:1000'],
            'area_sqm' => ['nullable', 'integer', 'min:1'],
            'access_code' => ['nullable', 'string', 'max:500'],
            'cleaning_instructions' => ['nullable', 'string', 'max:5000'],
            'schedule_info' => ['nullable', 'string', 'max:255'],
            'employees' => ['nullable', 'array'],
            'employees.*' => ['exists:users,id'],
        ]);

        $location->update($data);
        $location->employees()->sync($data['employees'] ?? []);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Obiekt został zaktualizowany.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $this->authorize('delete', $location);
        $location->delete();

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Obiekt został usunięty.');
    }
}
