@extends('admin.layout')
@section('title', 'Dashboard')
@section('header', 'Live Cleaning Feed')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Ostatnio ukończone zlecenia</p>
        </div>
        <a href="{{ route('admin.jobs.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Wszystkie zlecenia →</a>
    </div>

    @if ($jobs->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <svg class="mx-auto size-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="mt-3 text-sm font-medium text-slate-500">Brak ukończonych zleceń.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($jobs as $job)
                @php
                    $duration = null;
                    if ($job->started_at && $job->completed_at) {
                        $minutes = $job->started_at->diffInMinutes($job->completed_at);
                        $hours = (int) floor($minutes / 60);
                        $mins = $minutes % 60;
                        $duration = $hours > 0 ? "{$hours}h {$mins}m" : "{$mins}m";
                    }

                    $photos = collect();
                    if ($job->photo_path) {
                        $photos->push($job->photo_path);
                    }
                @endphp

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden transition-all hover:shadow-md">
                    {{-- Header --}}
                    <div class="border-b border-slate-100 px-5 py-4">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-900">{{ $job->location?->name ?? 'Bez lokalizacji' }}</p>
                                <p class="mt-0.5 text-xs text-slate-400">{{ $job->location?->address ?? '' }}</p>
                            </div>
                            @if ($duration)
                                <span class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">{{ $duration }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="px-5 py-4 space-y-3">
                        {{-- Employee --}}
                        <div class="flex items-center gap-2.5">
                            <div class="flex size-7 items-center justify-center rounded-full bg-slate-900 text-[10px] font-bold text-white">
                                {{ substr($job->employee?->name ?? '?', 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-slate-700">{{ $job->employee?->name ?? 'Nieprzypisany' }}</span>
                        </div>

                        {{-- Timing --}}
                        <div class="flex items-center gap-4 text-xs text-slate-500">
                            @if ($job->started_at)
                                <span class="flex items-center gap-1">
                                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Start: {{ $job->started_at->format('H:i') }}
                                </span>
                            @endif
                            @if ($job->completed_at)
                                <span class="flex items-center gap-1">
                                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Koniec: {{ $job->completed_at->format('H:i') }}
                                </span>
                            @endif
                        </div>

                        {{-- Photos --}}
                        @if ($photos->isNotEmpty())
                            <div class="flex gap-2 overflow-x-auto pb-1">
                                @foreach ($photos as $photo)
                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="shrink-0">
                                        <img src="{{ asset('storage/' . $photo) }}" alt="Zdjęcie" class="h-20 w-20 rounded-xl object-cover ring-1 ring-slate-200 transition-all hover:ring-emerald-400">
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        {{-- Notes --}}
                        @if ($job->notes)
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $job->notes }}</p>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-2.5">
                        <p class="text-[11px] text-slate-400">{{ $job->completed_at?->translatedFormat('d.m.Y H:i') ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
