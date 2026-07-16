<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCleanLogRequest;
use App\Models\CleanLog;
use App\Models\QrPassport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CleanLogController extends Controller
{
    public function create(): View
    {
        $this->authorize('create', CleanLog::class);

        $user = auth()->user();

        if ($user->isPracownik()) {
            $passports = QrPassport::with('location')
                ->whereIn('location_id', $user->locations()->pluck('location_id'))
                ->orderBy('zone_name')
                ->get();
        } else {
            $passports = QrPassport::with('location')->orderBy('zone_name')->get();
        }

        return view('admin.clean-logs.create', compact('passports'));
    }

    public function store(StoreCleanLogRequest $request): RedirectResponse
    {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('clean-photos', 'public');
        }

        $passport = QrPassport::find($request->input('qr_passport_id'));

        CleanLog::create([
            'location_id' => $passport?->location_id,
            'qr_passport_id' => $request->input('qr_passport_id'),
            'user_id' => $request->user()->id,
            'cleaned_at' => now(),
            'photo_path' => $photoPath,
            'notes' => $request->input('notes'),
        ]);

        return redirect()
            ->route('admin.clean-logs.create')
            ->with('success', 'Sprzątanie zostało oznaczone jako wykonane.');
    }
}
