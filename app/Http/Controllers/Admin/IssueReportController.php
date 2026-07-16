<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResolveIssueReportRequest;
use App\Http\Requests\UpdateIssueReportRequest;
use App\Models\IssueReport;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IssueReportController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', IssueReport::class);

        $status = request()->query('status');
        $user = auth()->user();

        $query = IssueReport::with(['location', 'assignee'])
            ->latest();

        // Własne lokalizacje klienta
        if ($user->isKlient()) {
            $query->whereIn('location_id', $user->clientLocations()->pluck('id'));
        }

        // Lokalizacje przypisane pracownikowi
        if ($user->isPracownik()) {
            $query->whereIn('location_id', $user->locations()->pluck('location_id'));
        }

        if (in_array($status, ['pending', 'processing', 'resolved'])) {
            $query->where('status', $status);
        }

        $issues = $query->paginate(15)->withQueryString();
        $employees = User::where('role', 'pracownik')->orderBy('name')->get();

        return view('admin.issue-reports.index', compact('issues', 'employees', 'status'));
    }

    public function update(UpdateIssueReportRequest $request, IssueReport $issueReport): RedirectResponse
    {
        $issueReport->update([
            'status' => $request->input('status'),
            'assigned_to' => $request->input('assigned_to'),
        ]);

        return back()->with('success', 'Zgłoszenie zostało zaktualizowane.');
    }

    public function resolve(ResolveIssueReportRequest $request, IssueReport $issueReport): RedirectResponse
    {
        $this->authorize('resolve', $issueReport);

        $photoPath = null;
        if ($request->hasFile('resolution_photo')) {
            $photoPath = $request->file('resolution_photo')->store('resolution-photos', 'public');
        }

        $issueReport->update([
            'status' => IssueReport::STATUS_RESOLVED,
            'resolved_at' => now(),
            'resolution_photo_path' => $photoPath,
        ]);

        return back()->with('success', 'Zgłoszenie zostało oznaczone jako rozwiązane.');
    }
}
