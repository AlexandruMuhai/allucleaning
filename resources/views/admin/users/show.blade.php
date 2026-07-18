@extends('admin.layout')
@section('title', $user->name)
@section('header', 'Profil pracownika')

@section('content')
<div class="space-y-6">
    {{-- Profile header --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
            {{-- Photo --}}
            @if ($user->photo)
                <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="size-20 rounded-2xl object-cover ring-2 ring-slate-200">
            @else
                <div class="flex size-20 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-2xl font-extrabold text-white shadow-lg">
                    {{ $user->initial }}
                </div>
            @endif

            {{-- Info --}}
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3">
                    <h2 class="font-display text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    @include('admin.users.partials.role-badge', ['role' => $user->role])
                    @if ($user->isKrkVerified())
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                            <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Zweryfikowany KRK
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                            Niezweryfikowany KRK
                        </span>
                    @endif
                </div>
                <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                @if ($user->hourly_rate)
                    <p class="mt-1 text-sm font-semibold text-slate-700">{{ number_format($user->hourly_rate, 2, ',', ' ') }} zł/h</p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-200">Edytuj</a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Przepracowane</p>
            <p class="mt-1 font-display text-2xl font-extrabold text-slate-900">{{ number_format($totalHours, 1, ',', ' ') }}h</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Zarobek łącznie</p>
            <p class="mt-1 font-display text-2xl font-extrabold text-emerald-700">{{ number_format($totalEarnings, 2, ',', ' ') }} zł</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Zlecenia ukończone</p>
            <p class="mt-1 font-display text-2xl font-extrabold text-slate-900">{{ $completedJobs->count() }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-center shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Przypisane obiekty</p>
            <p class="mt-1 font-display text-2xl font-extrabold text-slate-900">{{ $assignedLocations->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            {{-- Grafik tygodniowy --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                    <h3 class="font-display text-base font-bold text-slate-900">Grafik na ten tydzień</h3>
                    <a href="{{ route('admin.schedule.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Pełny grafik ↗</a>
                </div>
                @if ($currentWeekJobs->isEmpty())
                    <p class="px-6 py-6 text-center text-sm text-slate-500">Brak zleceń w tym tygodniu.</p>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($currentWeekJobs->groupBy('scheduled_date') as $date => $dayJobs)
                            <div class="px-6 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $date->translatedFormat('l, d.m') }}</p>
                                <div class="mt-2 space-y-2">
                                    @foreach ($dayJobs as $job)
                                        <div class="flex items-center gap-3 rounded-xl bg-slate-50 px-4 py-2.5">
                                            <span class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($job->scheduled_time)->format('H:i') }}</span>
                                            <span class="text-sm text-slate-600">{{ $job->location?->name ?? '—' }}</span>
                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[10px] font-medium {{ $job->statusColor() }}">{{ $job->statusLabel() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Ewidencja czasu --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="font-display text-base font-bold text-slate-900">Ewidencja czasu pracy</h3>
                </div>
                @if ($completedJobs->isEmpty())
                    <p class="px-6 py-6 text-center text-sm text-slate-500">Brak ukończonych zleceń.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-400">Data</th>
                                    <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-400">Lokalizacja</th>
                                    <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-400">Start</th>
                                    <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-400">Koniec</th>
                                    <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-400">Czas</th>
                                    <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-400">GPS</th>
                                    <th class="px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-slate-400">Zarobek</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($completedJobs as $job)
                                    <tr class="transition-colors hover:bg-slate-50">
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $job->scheduled_date->format('d.m') }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $job->location?->name ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">
                                            {{ $job->started_at->format('H:i') }}
                                            @if ($job->start_latitude)
                                                <span class="ml-1 inline-flex size-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-600" title="GPS zweryfikowany">
                                                    <svg class="size-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                </span>
                                            @else
                                                <span class="ml-1 inline-flex size-4 items-center justify-center rounded-full bg-slate-100 text-slate-400" title="Brak danych GPS">
                                                    <svg class="size-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $job->completed_at->format('H:i') }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-semibold text-slate-900">{{ $job->duration_label ?? '—' }}</td>
                                        <td class="px-4 py-3">
                                            @if ($job->start_latitude && $job->end_latitude)
                                                <span class="text-[10px] font-medium text-emerald-600">Start + Koniec</span>
                                            @elseif ($job->start_latitude)
                                                <span class="text-[10px] font-medium text-amber-600">Tylko start</span>
                                            @else
                                                <span class="text-[10px] font-medium text-slate-400">Brak</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-bold text-emerald-700">
                                            {{ $job->earnings ? number_format($job->earnings, 2, ',', ' ') . ' zł' : '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Przypisane obiekty --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-3">Przypisane obiekty</h3>
                @if ($assignedLocations->isEmpty())
                    <p class="text-sm text-slate-500">Brak przypisanych lokalizacji.</p>
                @else
                    <ul class="space-y-2">
                        @foreach ($assignedLocations as $loc)
                            <li class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-2.5">
                                <div>
                                    <a href="{{ route('admin.locations.show', $loc) }}" class="text-sm font-semibold text-slate-900 hover:text-emerald-600">{{ $loc->name }}</a>
                                    <p class="text-xs text-slate-400">{{ $loc->address }}</p>
                                </div>
                                <span class="text-xs text-slate-400">{{ $loc->cleaning_jobs_count }} zleceń</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- KRK --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-display text-base font-bold text-slate-900 mb-3">Weryfikacja KRK</h3>
                @if ($user->krk_verified)
                    <div class="flex items-center gap-2 rounded-xl bg-emerald-50 p-3">
                        <svg class="size-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-emerald-800">Zweryfikowany</p>
                            @if ($user->krk_verified_at)
                                <p class="text-xs text-emerald-600">{{ $user->krk_verified_at->translatedFormat('d.m.Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-500">Pracownik nie został jeszcze zweryfikowany.</p>
                @endif
                @if ($user->krk_document_path)
                    <a href="{{ asset('storage/' . $user->krk_document_path) }}" target="_blank" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                        <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Pobierz skan KRK
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
