@extends('admin.layout')
@section('title', $location->name)
@section('header', $location->name)

@php
    $completedJobs = $location->cleaningJobs()
        ->where('status', 'completed')
        ->whereNotNull('started_at')
        ->whereNotNull('completed_at')
        ->with('employee')
        ->get();

    $totalHours = 0;
    $laborCost = 0;
    foreach ($completedJobs as $cj) {
        $hours = $cj->started_at->diffInMinutes($cj->completed_at) / 60;
        $totalHours += $hours;
        if ($cj->employee?->hourly_rate) {
            $laborCost += $hours * $cj->employee->hourly_rate;
        }
    }

    $revenue = $location->monthly_revenue ?? 0;
    $netProfit = $revenue - $laborCost;
@endphp

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            {{-- Podsumowanie finansowe --}}
            @if ($revenue > 0 || $laborCost > 0)
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-display text-base font-bold text-slate-900 mb-4">Podsumowanie finansowe</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="rounded-xl bg-slate-50 p-4 text-center">
                            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Przychód / mc</p>
                            <p class="mt-1 font-display text-xl font-extrabold text-slate-900">{{ number_format($revenue, 2, ',', ' ') }} zł</p>
                        </div>
                        <div class="rounded-xl bg-rose-50 p-4 text-center">
                            <p class="text-xs font-medium uppercase tracking-wider text-rose-400">Koszt pracy</p>
                            <p class="mt-1 font-display text-xl font-extrabold text-rose-700">{{ number_format($laborCost, 2, ',', ' ') }} zł</p>
                            <p class="mt-0.5 text-[10px] text-rose-400">{{ number_format($totalHours, 1, ',', ' ') }}h łącznie</p>
                        </div>
                        <div class="rounded-xl {{ $netProfit >= 0 ? 'bg-emerald-50' : 'bg-rose-50' }} p-4 text-center">
                            <p class="text-xs font-medium uppercase tracking-wider {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">Zysk netto</p>
                            <p class="mt-1 font-display text-xl font-extrabold {{ $netProfit >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">{{ number_format($netProfit, 2, ',', ' ') }} zł</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Informacje podstawowe --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-4">Informacje</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-slate-500">Typ</dt>
                        <dd class="font-medium text-slate-900">{{ $location->typeLabel() }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Klient</dt>
                        <dd class="font-medium text-slate-900">{{ $location->client?->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Adres</dt>
                        <dd class="font-medium text-slate-900">{{ $location->address ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Metraż</dt>
                        <dd class="font-medium text-slate-900">{{ $location->area_sqm ? $location->area_sqm . ' m²' : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Harmonogram</dt>
                        <dd class="font-medium text-slate-900">{{ $location->schedule_info ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Status</dt>
                        <dd><span class="inline-flex items-center gap-1 text-xs font-medium {{ $location->is_active ? 'text-emerald-600' : 'text-slate-400' }}"><span class="size-1.5 rounded-full {{ $location->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>{{ $location->is_active ? 'Aktywna' : 'Nieaktywna' }}</span></dd>
                    </div>
                    @if ($location->latitude && $location->longitude)
                    <div class="col-span-2">
                        <dt class="text-slate-500">GPS</dt>
                        <dd class="font-medium text-slate-900 font-mono text-xs">{{ $location->latitude }}, {{ $location->longitude }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Kod dostępu (admin widzi) --}}
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-amber-800 mb-2">Kod dostępu</h3>
                <p class="text-sm text-amber-900 font-mono bg-white/60 rounded-lg p-3 ring-1 ring-amber-200">{{ $location->access_code ?? 'Brak kodu' }}</p>
                <p class="mt-2 text-xs text-amber-600">Dane wrażliwe — wyświetlane tylko administratorom.</p>
            </div>

            {{-- Instrukcje sprzątania --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-2">Instrukcje sprzątania</h3>
                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $location->cleaning_instructions ?? 'Brak instrukcji.' }}</p>
            </div>

            {{-- Harmonogram --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-base font-bold text-slate-900">Harmonogram sprzątania</h3>
                    <a href="{{ route('admin.schedules.index', $location) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Zarządzaj ↗</a>
                </div>
                @php $tpls = $location->scheduleTemplates()->with('defaultEmployee')->orderBy('day_of_week')->get(); @endphp
                @if ($tpls->isNotEmpty())
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($tpls as $tpl)
                            <li class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-2.5">
                                <span class="font-medium text-slate-900">{{ $tpl->dayOfWeekLabel() }} o {{ \Carbon\Carbon::parse($tpl->start_time)->format('H:i') }}</span>
                                <span class="text-xs text-slate-500">{{ $tpl->defaultEmployee?->name ?? 'Bez pracownika' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-2 text-xs text-slate-400">Brak ustawionych szablonów. Dodaj dzień sprzątania, aby system generował zlecenia automatycznie.</p>
                @endif
            </div>

            {{-- Ostatnie sprzątania --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                    <h3 class="font-display text-base font-bold text-slate-900">Ostatnie sprzątania</h3>
                    <a href="{{ route('admin.clean-logs.create') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">+ Dodaj</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($location->cleanLogs()->latest('cleaned_at')->with('user')->limit(10)->get() as $log)
                        <div class="flex items-center gap-3 px-6 py-3">
                            @if ($log->photo_path)
                                <img src="{{ asset('storage/' . $log->photo_path) }}" class="size-12 rounded-lg object-cover">
                            @else
                                <div class="flex size-12 items-center justify-center rounded-lg bg-slate-100 text-slate-400"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $log->cleaned_at->translatedFormat('d.m.Y H:i') }} · {{ $log->user?->name ?? 'Pracownik' }}</p>
                                @if ($log->notes)<p class="truncate text-xs text-slate-500">{{ $log->notes }}</p>@endif
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-6 text-center text-sm text-slate-500">Brak wpisów.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Boczne: paszporty i zgłoszenia --}}
        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-3">Paszporty QR</h3>
                <ul class="divide-y divide-slate-100 text-sm">
                    @forelse ($location->passports as $passport)
                        <li class="py-2">
                            <a href="{{ route('admin.passports.show', $passport) }}" class="font-medium text-slate-900 hover:text-emerald-600">{{ $passport->zone_name }}</a>
                            <p class="text-xs text-slate-400">{{ substr($passport->uuid, 0, 8) }}…</p>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500">Brak paszportów.</li>
                    @endforelse
                </ul>
                @if (auth()->user()->isAdministrator())
                    <a href="{{ route('admin.passports.create') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">+ Dodaj paszport</a>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-3">Zgłoszenia</h3>
                @php
                    $statusStyles = ['pending' => 'bg-rose-50 text-rose-700', 'processing' => 'bg-amber-50 text-amber-700', 'resolved' => 'bg-emerald-50 text-emerald-700'];
                    $statusLabels = ['pending' => 'Oczekujące', 'processing' => 'W toku', 'resolved' => 'Rozwiązane'];
                @endphp
                <ul class="divide-y divide-slate-100 text-sm">
                    @forelse ($location->issueReports()->latest()->limit(5)->get() as $issue)
                        <li class="flex items-center justify-between gap-2 py-2">
                            <span class="truncate text-slate-700">{{ $issue->description }}</span>
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-medium {{ $statusStyles[$issue->status] }}">{{ $statusLabels[$issue->status] }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500">Brak zgłoszeń.</li>
                    @endforelse
                </ul>
                <a href="{{ route('admin.issue-reports.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">Zobacz wszystkie</a>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-3">Przypisani pracownicy</h3>
                <ul class="text-sm text-slate-700">
                    @forelse ($location->employees as $emp)
                        <li class="py-1">{{ $emp->name }}@if ($emp->hourly_rate) <span class="text-xs text-slate-400">· {{ number_format($emp->hourly_rate, 2, ',', ' ') }} zł/h</span>@endif</li>
                    @empty
                        <li class="py-1 text-slate-400">Brak przypisanych.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
