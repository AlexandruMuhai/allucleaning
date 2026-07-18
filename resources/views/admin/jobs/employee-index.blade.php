@extends('admin.layout')
@section('title', 'Moje zlecenia')
@section('header', 'Plan na dziś — ' . \Carbon\Carbon::today()->translatedFormat('l, d.m.Y'))

@section('content')
<div class="mx-auto max-w-lg space-y-3" x-data="{ expanded: null }">

    @if ($jobs->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <svg class="mx-auto size-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="mt-3 text-sm font-medium text-slate-500">Nie masz zleceń na dziś.</p>
            <p class="mt-1 text-xs text-slate-400">Sprawdź jutro!</p>
        </div>
    @endif

    @foreach ($jobs as $job)
        @php
            $isActive = $job->isInProgress();
            $isCompleted = $job->isCompleted();
            $isPending = $job->isPending();
            $isLate = $isPending && $job->schedule_start->lt(now());
        @endphp

        <div class="overflow-hidden rounded-2xl border transition-all {{ $isActive ? 'border-amber-300 bg-amber-50 shadow-md shadow-amber-100' : ($isLate ? 'border-rose-300 bg-rose-50 shadow-md shadow-rose-100' : ($isCompleted ? 'border-emerald-200 bg-emerald-50/50' : 'border-slate-200 bg-white shadow-sm')) }}">

            {{-- Collapsed header (always visible) --}}
            <button @click="expanded = expanded === {{ $job->id }} ? null : {{ $job->id }}" class="flex w-full items-center gap-4 p-4 text-left">
                {{-- Time --}}
                <div class="shrink-0 text-center">
                    <p class="font-display text-2xl font-extrabold {{ $isLate ? 'text-rose-600' : ($isActive ? 'text-amber-600' : ($isCompleted ? 'text-emerald-600' : 'text-slate-900')) }}">
                        {{ \Carbon\Carbon::parse($job->scheduled_time)->format('H:i') }}
                    </p>
                </div>

                {{-- Location info --}}
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        @if ($isLate)
                            <span class="inline-flex size-2 shrink-0 rounded-full bg-rose-500 animate-pulse"></span>
                        @elseif ($isActive)
                            <span class="inline-flex size-2 shrink-0 rounded-full bg-amber-500 animate-pulse"></span>
                        @elseif ($isCompleted)
                            <span class="inline-flex size-2 shrink-0 rounded-full bg-emerald-500"></span>
                        @else
                            <span class="inline-flex size-2 shrink-0 rounded-full bg-slate-400"></span>
                        @endif
                        <p class="truncate text-sm font-bold text-slate-900">{{ $job->location?->name ?? 'Bez lokalizacji' }}</p>
                    </div>
                    <p class="mt-0.5 truncate text-xs text-slate-500">{{ $job->location?->address ?? '' }}</p>
                </div>

                {{-- Status badge --}}
                <div class="shrink-0">
                    @if ($isLate)
                        <span class="rounded-full bg-rose-100 px-2.5 py-1 text-[10px] font-bold text-rose-700 animate-pulse">ALARM</span>
                    @elseif ($isActive)
                        <span class="rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold text-amber-700">W TOKU</span>
                    @elseif ($isCompleted)
                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700">GOTOWE</span>
                    @else
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-500">CZEKA</span>
                    @endif
                </div>

                {{-- Chevron --}}
                <svg class="size-5 shrink-0 text-slate-400 transition-transform" :class="expanded === {{ $job->id }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            {{-- Expanded details --}}
            <div x-show="expanded === {{ $job->id }}" x-collapse x-cloak class="border-t border-slate-100 px-4 pb-4 pt-3 space-y-4">

                {{-- Access code (only when in_progress) --}}
                @if ($isActive && $job->location?->access_code)
                    <div class="rounded-xl border-2 border-amber-300 bg-amber-50 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="size-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            <span class="text-sm font-bold text-amber-800">Kod dostępu</span>
                        </div>
                        <p class="font-mono text-xl font-bold text-amber-900 bg-white/60 rounded-lg p-3 text-center ring-1 ring-amber-200 select-all tracking-wider">{{ $job->location->access_code }}</p>
                    </div>
                @endif

                {{-- Instructions (only when in_progress) --}}
                @if ($isActive && $job->location?->cleaning_instructions)
                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="size-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span class="text-sm font-bold text-blue-800">Instrukcje</span>
                        </div>
                        <p class="text-sm text-blue-900 whitespace-pre-wrap">{{ $job->location->cleaning_instructions }}</p>
                    </div>
                @endif

                {{-- Pending: show access code preview --}}
                @if ($isPending && $job->location?->access_code)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-center">
                        <p class="text-xs text-slate-500">Kod dostępu pojawi się po rozpoczęciu zlecenia.</p>
                    </div>
                @endif

                {{-- Action button: START --}}
                @if ($isPending)
                    <form method="POST" action="{{ route('admin.jobs.start', $job) }}" x-data="startGeo()" @submit="requestGeolocation($event)">
                        @csrf
                        <input type="hidden" name="user_lat" :value="lat">
                        <input type="hidden" name="user_lng" :value="lng">
                        <button type="submit" class="w-full rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-4 text-base font-bold text-white shadow-lg shadow-emerald-600/25 active:scale-[0.98]">
                            ▶ Zacznij sprzątanie
                        </button>
                    </form>
                @endif

                {{-- Action button: COMPLETE --}}
                @if ($isActive)
                    <form method="POST" action="{{ route('admin.jobs.complete', $job) }}" enctype="multipart/form-data" x-data="completionGeo()">
                        @csrf
                        <input type="hidden" name="user_lat" :value="lat">
                        <input type="hidden" name="user_lng" :value="lng">
                        <div class="space-y-3">
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Zdjęcie <span class="text-rose-500">*</span></label>
                                <input type="file" name="photo" accept="image/*" capture="environment" required
                                       class="w-full rounded-xl border-slate-300 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2.5 file:text-sm file:font-bold file:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Notatka</label>
                                <textarea name="notes" rows="2" class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm" placeholder="Opcjonalna notatka"></textarea>
                            </div>
                            <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/25 active:scale-[0.98]">✓ Zakończ zlecenie</button>
                        </div>
                    </form>
                @endif

                {{-- Completed summary --}}
                @if ($isCompleted)
                    <div class="rounded-xl bg-emerald-50 p-4 text-center">
                        <p class="text-sm font-bold text-emerald-700">✓ Zlecenie ukończone</p>
                        @if ($job->completed_at)
                            <p class="mt-1 text-xs text-emerald-600">{{ $job->completed_at->translatedFormat('H:i') }}</p>
                        @endif
                        @if ($job->photo_path)
                            <img src="{{ asset('storage/' . $job->photo_path) }}" class="mt-2 mx-auto max-h-32 rounded-xl object-cover">
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
function startGeo() {
    return {
        lat: null,
        lng: null,

        requestGeolocation(event) {
            if (!navigator.geolocation) return;

            event.preventDefault();
            const form = event.target;
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = '📡 Sprawdzam lokalizację…';

            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this.lat = pos.coords.latitude;
                    this.lng = pos.coords.longitude;
                    form.submit();
                },
                () => form.submit(),
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }
    }
}

function completionGeo() {
    return {
        lat: null,
        lng: null,
        init() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => { this.lat = pos.coords.latitude; this.lng = pos.coords.longitude; },
                    () => {},
                    { enableHighAccuracy: false, timeout: 5000, maximumAge: 300000 }
                );
            }
        }
    }
}
</script>
@endsection
