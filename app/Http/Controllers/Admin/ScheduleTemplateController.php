<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningScheduleTemplate;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleTemplateController extends Controller
{
    public function index(Location $location): View
    {
        $templates = $location->scheduleTemplates()
            ->with('defaultEmployee')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view('admin.schedules.index', compact('location', 'templates'));
    }

    public function create(Location $location): View
    {
        $employees = User::where('role', 'pracownik')->orderBy('name')->get();

        return view('admin.schedules.create', compact('location', 'employees'));
    }

    public function store(Request $request, Location $location): RedirectResponse
    {
        $data = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
            'start_time' => ['required', 'date_format:H:i'],
            'default_employee_id' => ['nullable', 'exists:users,id'],
        ]);

        $location->scheduleTemplates()->create($data);

        return redirect()
            ->route('admin.schedules.index', $location)
            ->with('success', 'Szablon harmonogramu został dodany.');
    }

    public function edit(Location $location, CleaningScheduleTemplate $template): View
    {
        $employees = User::where('role', 'pracownik')->orderBy('name')->get();

        return view('admin.schedules.edit', compact('location', 'template', 'employees'));
    }

    public function update(Request $request, Location $location, CleaningScheduleTemplate $template): RedirectResponse
    {
        $data = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
            'start_time' => ['required', 'date_format:H:i'],
            'default_employee_id' => ['nullable', 'exists:users,id'],
        ]);

        $template->update($data);

        return redirect()
            ->route('admin.schedules.index', $location)
            ->with('success', 'Szablon został zaktualizowany.');
    }

    public function destroy(Location $location, CleaningScheduleTemplate $template): RedirectResponse
    {
        $template->delete();

        return redirect()
            ->route('admin.schedules.index', $location)
            ->with('success', 'Szablon został usunięty.');
    }
}
