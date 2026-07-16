<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQrPassportRequest;
use App\Http\Requests\UpdateQrPassportRequest;
use App\Models\Location;
use App\Models\QrPassport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrPassportController extends Controller
{
    public function index(): View
    {
        $passports = QrPassport::with(['location'])
            ->latest()
            ->paginate(15);

        return view('admin.passports.index', compact('passports'));
    }

    public function create(): View
    {
        $locations = Location::orderBy('name')->get();

        return view('admin.passports.create', compact('locations'));
    }

    public function store(StoreQrPassportRequest $request): RedirectResponse
    {
        QrPassport::create([
            'uuid' => (string) Str::uuid(),
            'location_id' => $request->input('location_id'),
            'zone_name' => $request->input('zone_name'),
            'next_scheduled_clean' => $request->input('next_scheduled_clean'),
        ]);

        return redirect()
            ->route('admin.passports.index')
            ->with('success', 'Kod QR został utworzony.');
    }

    public function show(QrPassport $passport): View
    {
        $this->authorize('view', $passport);

        $passport->load([
            'location',
            'cleanLogs' => fn ($q) => $q->latest('cleaned_at')->with('user'),
            'issueReports' => fn ($q) => $q->latest()->with('assignee'),
        ]);

        $qrSvg = QrCode::size(320)->margin(2)->generate(route('passport.show', $passport->uuid));

        return view('admin.passports.show', compact('passport', 'qrSvg'));
    }

    public function edit(QrPassport $passport): View
    {
        $this->authorize('update', $passport);
        $locations = Location::orderBy('name')->get();

        return view('admin.passports.edit', compact('passport', 'locations'));
    }

    public function update(UpdateQrPassportRequest $request, QrPassport $passport): RedirectResponse
    {
        $passport->update([
            'location_id' => $request->input('location_id'),
            'zone_name' => $request->input('zone_name'),
            'next_scheduled_clean' => $request->input('next_scheduled_clean'),
        ]);

        return redirect()
            ->route('admin.passports.index')
            ->with('success', 'Kod QR został zaktualizowany.');
    }

    public function destroy(QrPassport $passport): RedirectResponse
    {
        $this->authorize('delete', $passport);
        $passport->delete();

        return redirect()
            ->route('admin.passports.index')
            ->with('success', 'Kod QR został usunięty.');
    }
}
