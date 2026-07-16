@extends('admin.layout')
@section('title', $location->name)
@section('header', $location->name)

@section('content')
<div class="mx-auto max-w-lg space-y-4">

    {{-- Duży przycisk "Zacznij sprzątanie" --}}
    @can('viewSensitive', $location)
    <a href="{{ route('admin.clean-logs.create') }}" class="flex w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-5 text-center text-lg font-bold text-white shadow-lg shadow-emerald-600/25 transition-all hover:shadow-emerald-500/40 active:scale-[0.98]">
        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        Zacznij sprzątanie
    </a>
    @endcan

    {{-- Jak wejść --}}
    @can('viewSensitive', $location)
    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
        <div class="flex items-center gap-2 mb-2">
            <svg class="size-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            <h3 class="font-display text-base font-bold text-amber-800">Jak wejść</h3>
        </div>
        <p class="font-mono text-lg font-bold text-amber-900 bg-white/60 rounded-xl p-4 text-center ring-1 ring-amber-200 select-all">{{ $location->access_code ?? 'Brak kodu' }}</p>
    </div>
    @else
    <div class="rounded-2xl border border-slate-200 bg-white p-5 text-center">
        <p class="text-sm text-slate-500">Dane dostępu dostępne w dniu zaplanowanego sprzątania.</p>
    </div>
    @endcan

    {{-- Instrukcje sprzątania --}}
    @can('viewSensitive', $location)
    @if ($location->cleaning_instructions)
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="size-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <h3 class="font-display text-base font-bold text-slate-900">Instrukcje sprzątania</h3>
        </div>
        <p class="text-sm text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $location->cleaning_instructions }}</p>
    </div>
    @endif
    @endcan

    {{-- Info o lokalizacji --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="font-display text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">Informacje</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Typ</dt><dd class="font-medium text-slate-900">{{ $location->typeLabel() }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Adres</dt><dd class="font-medium text-slate-900">{{ $location->address ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Harmonogram</dt><dd class="font-medium text-slate-900">{{ $location->schedule_info ?? '—' }}</dd></div>
            @if ($location->area_sqm)<div class="flex justify-between"><dt class="text-slate-500">Metraż</dt><dd class="font-medium text-slate-900">{{ $location->area_sqm }} m²</dd></div>@endif
        </dl>
    </div>

    {{-- Strefy QR --}}
    @if ($location->passports->isNotEmpty())
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="font-display text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">Strefy QR</h3>
        <ul class="space-y-2 text-sm">
            @foreach ($location->passports as $passport)
                <li class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-2.5">
                    <span class="font-medium text-slate-900">{{ $passport->zone_name }}</span>
                    <a href="{{ route('admin.passports.show', $passport) }}" class="text-xs font-semibold text-emerald-600 hover:underline">Szczegóły</a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
