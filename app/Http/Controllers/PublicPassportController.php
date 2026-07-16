<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueReportRequest;
use App\Models\IssueReport;
use App\Models\QrPassport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicPassportController extends Controller
{
    public function show(string $uuid): View
    {
        $passport = QrPassport::with(['location', 'cleanLogs' => fn ($q) => $q->latest('cleaned_at')->limit(5), 'cleanLogs.user'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        $lastClean = $passport->cleanLogs->first();
        $recentIssues = $passport->issueReports()
            ->latest()
            ->limit(5)
            ->get();

        return view('public.passport', compact('passport', 'lastClean', 'recentIssues'));
    }

    public function storeIssue(string $uuid, StoreIssueReportRequest $request): RedirectResponse
    {
        $passport = QrPassport::where('uuid', $uuid)->firstOrFail();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('issue-photos', 'public');
        }

        IssueReport::create([
            'location_id' => $passport->location_id,
            'qr_passport_id' => $passport->id,
            'reporter_name' => $request->input('reporter_name'),
            'description' => $request->input('description'),
            'photo_path' => $photoPath,
            'status' => IssueReport::STATUS_PENDING,
        ]);

        return back()->with('success', 'Dziękujemy! Twoje zgłoszenie zostało przyjęte.');
    }
}
