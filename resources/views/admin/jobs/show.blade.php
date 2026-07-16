@extends('admin.layout')
@section('title', 'Szczegóły zlecenia')
@section('header', 'Zlecenie #' . $job->id)

@section('content')
<div class="mx-auto max-w-2xl space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Status</dt><dd><span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $job->statusColor() }}">{{ $job->statusLabel() }}</span></dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Data</dt><dd class="font-medium text-slate-900">{{ $job->scheduled_date->translatedFormat('l, d.m.Y') }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Godzina</dt><dd class="font-medium text-slate-900">{{ \Carbon\Carbon::parse($job->scheduled_time)->format('H:i') }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Lokalizacja</dt><dd class="font-medium text-slate-900">{{ $job->location->name ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Pracownik</dt><dd class="font-medium text-slate-900">{{ $job->employee?->name ?? '—' }}</dd></div>
            @if ($job->started_at)<div class="flex justify-between"><dt class="text-slate-500">Rozpoczęto</dt><dd class="text-slate-900">{{ $job->started_at->translatedFormat('d.m.Y H:i') }}</dd></div>@endif
            @if ($job->completed_at)<div class="flex justify-between"><dt class="text-slate-500">Zakończono</dt><dd class="text-slate-900">{{ $job->completed_at->translatedFormat('d.m.Y H:i') }}</dd></div>@endif
            @if ($job->notes)<div class="pt-2 border-t border-slate-100"><dt class="text-slate-500 mb-1">Notatki</dt><dd class="text-slate-700 whitespace-pre-wrap">{{ $job->notes }}</dd></div>@endif
        </dl>
        @if ($job->photo_path)
            <div class="mt-4"><img src="{{ asset('storage/' . $job->photo_path) }}" alt="Zdjęcie" class="max-h-60 rounded-xl object-cover"></div>
        @endif
    </div>

    {{-- Quick status change --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-wrap gap-2">
            @if (!$job->isCancelled() && !$job->isCompleted())
                <form method="POST" action="{{ route('admin.jobs.status', $job) }}" class="inline">@csrf
                    <input type="hidden" name="status" value="cancelled">
                    <button class="rounded-lg bg-rose-50 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100">Anuluj zlecenie</button>
                </form>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">← Wróć do listy</a>
</div>
@endsection
