@extends('admin.layout')
@section('title', 'Zlecenie')
@section('header', $job->location?->name ?? 'Zlecenie')

@section('content')
<div class="mx-auto max-w-lg space-y-4">

    {{-- Status + godzina --}}
    <div class="rounded-2xl border {{ $job->isInProgress() ? 'border-amber-300 bg-amber-50' : 'border-slate-200 bg-white' }} p-5 shadow-sm text-center">
        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $job->statusColor() }}">{{ $job->statusLabel() }}</span>
        <p class="font-display text-4xl font-extrabold text-slate-900 mt-2">{{ \Carbon\Carbon::parse($job->scheduled_time)->format('H:i') }}</p>
        <p class="text-sm text-slate-500">{{ $job->scheduled_date->translatedFormat('l, d.m.Y') }}</p>
    </div>

    {{-- Lokalizacja info --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h3 class="font-display text-base font-bold text-slate-900 mb-2">{{ $job->location->name ?? '—' }}</h3>
        <p class="text-sm text-slate-500">{{ $job->location?->address }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $job->location?->typeLabel() }}{{ $job->location?->area_sqm ? ' · ' . $job->location->area_sqm . ' m²' : '' }}</p>
    </div>

    {{-- Jak wejść --}}
    @if ($job->location?->access_code)
    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
        <div class="flex items-center gap-2 mb-2">
            <svg class="size-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            <h3 class="font-display text-base font-bold text-amber-800">Kod dostępu</h3>
        </div>
        <p class="font-mono text-lg font-bold text-amber-900 bg-white/60 rounded-xl p-4 text-center ring-1 ring-amber-200 select-all">{{ $job->location->access_code }}</p>
    </div>
    @endif

    {{-- Instrukcje --}}
    @if ($job->location?->cleaning_instructions)
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="size-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <h3 class="font-display text-base font-bold text-slate-900">Instrukcje</h3>
        </div>
        <p class="text-sm text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $job->location->cleaning_instructions }}</p>
    </div>
    @endif

    {{-- Przyciski akcji --}}
    <div class="space-y-3">
        @if ($job->isPending())
            <form method="POST" action="{{ route('admin.jobs.start', $job) }}">
                @csrf
                <button class="w-full rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-4 text-center text-lg font-bold text-white shadow-lg shadow-emerald-600/25 transition-all hover:shadow-emerald-500/40 active:scale-[0.98]">
                    ▶ Zacznij sprzątanie
                </button>
            </form>
        @endif

        @if ($job->isInProgress())
            <form method="POST" action="{{ route('admin.jobs.complete', $job) }}" enctype="multipart/form-data" class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 space-y-4">
                @csrf
                <h3 class="font-display text-base font-bold text-emerald-800">Oznacz jako ukończone</h3>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Zdjęcie (opcjonalnie)</label>
                    <input type="file" name="photo" accept="image/*" capture="environment" class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Notatki (opcjonalnie)</label>
                    <textarea name="notes" rows="2" class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. uzupełniono mydło, wymieniono ręczniki"></textarea>
                </div>
                <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">✓ Zakończ zlecenie</button>
            </form>
        @endif

        @if ($job->isCompleted())
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-center">
                <p class="font-display text-lg font-bold text-emerald-700">✓ Zlecenie ukończone</p>
                @if ($job->completed_at)<p class="text-sm text-emerald-600 mt-1">{{ $job->completed_at->translatedFormat('d.m.Y H:i') }}</p>@endif
                @if ($job->photo_path)<img src="{{ asset('storage/' . $job->photo_path) }}" class="mt-3 mx-auto max-h-40 rounded-xl object-cover">@endif
                @if ($job->notes)<p class="mt-2 text-sm text-slate-700 whitespace-pre-wrap">{{ $job->notes }}</p>@endif
            </div>
        @endif
    </div>
</div>
@endsection
