@extends('admin.layout')
@section('title', $job->location?->name ?? 'Zlecenie')
@section('header', $job->location?->name ?? 'Zlecenie')

@section('content')
<div class="mx-auto max-w-lg space-y-4" x-data="geolocation()">

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

    {{-- DANE DOSTĘPOWE — tylko gdy in_progress --}}
    @if ($job->isInProgress())
        {{-- Kod dostępu --}}
        @if ($job->location?->access_code)
            <div class="rounded-2xl border-2 border-amber-300 bg-amber-50 p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="size-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    <h3 class="font-display text-base font-bold text-amber-800">Kod dostępu</h3>
                </div>
                <p class="font-mono text-xl font-bold text-amber-900 bg-white/60 rounded-xl p-4 text-center ring-1 ring-amber-200 select-all tracking-wider">{{ $job->location->access_code }}</p>
            </div>
        @endif

        {{-- Instrukcje --}}
        @if ($job->location?->cleaning_instructions)
            <div class="rounded-2xl border-2 border-blue-200 bg-blue-50 p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="size-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <h3 class="font-display text-base font-bold text-blue-800">Instrukcje sprzątania</h3>
                </div>
                <p class="text-sm text-blue-900 whitespace-pre-wrap leading-relaxed">{{ $job->location->cleaning_instructions }}</p>
            </div>
        @endif
    @endif

    {{-- Przyciski akcji --}}
    <div class="space-y-3">
        {{-- Zacznij --}}
        @if ($job->isPending())
            <form method="POST" action="{{ route('admin.jobs.start', $job) }}" @submit="requestGeolocation($event)">
                @csrf
                <input type="hidden" name="user_lat" :value="lat">
                <input type="hidden" name="user_lng" :value="lng">
                <button type="submit" class="w-full rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-4 text-center text-lg font-bold text-white shadow-lg shadow-emerald-600/25 transition-all hover:shadow-emerald-500/40 active:scale-[0.98]">
                    ▶ Zacznij sprzątanie
                </button>
                @if ($gpsError)
                    <p class="mt-2 text-sm text-rose-600 text-center">{{ $gpsError }}</p>
                @endif
            </form>
            @if ($errors->has('gps'))
                <p class="text-sm text-rose-600 text-center">{{ $errors->first('gps') }}</p>
            @endif
        @endif

        {{-- Zakończ --}}
        @if ($job->isInProgress())
            <form method="POST" action="{{ route('admin.jobs.complete', $job) }}" enctype="multipart/form-data" x-data="completionGeo()" class="rounded-2xl border-2 border-emerald-300 bg-emerald-50 p-5 space-y-4 shadow-sm">
                @csrf
                <input type="hidden" name="user_lat" :value="lat">
                <input type="hidden" name="user_lng" :value="lng">
                <h3 class="font-display text-base font-bold text-emerald-800">Oznacz jako ukończone</h3>
                <div>
                    <label for="photo" class="mb-1.5 block text-sm font-semibold text-slate-700">Zdjęcie wykonanej pracy <span class="text-rose-500">*</span></label>
                    <input id="photo" type="file" name="photo" accept="image/*" capture="environment" required
                           class="w-full rounded-xl border-slate-300 text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2.5 file:text-sm file:font-bold file:text-white file:shadow-lg file:shadow-emerald-600/25 file:transition-all file:hover:bg-emerald-500">
                </div>
                <div>
                    <label for="notes" class="mb-1.5 block text-sm font-semibold text-slate-700">Notatka</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. uzupełniono mydło, wymieniono ręczniki"></textarea>
                </div>
                <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-4 text-base font-bold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">
                    ✓ Zakończ zlecenie
                </button>
            </form>
        @endif

        {{-- Ukończone --}}
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

@push('scripts')
<script>
function geolocation() {
    return {
        lat: null,
        lng: null,
        gpsError: null,

        requestGeolocation(event) {
            if (!navigator.geolocation) {
                return;
            }

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
                (err) => {
                    this.gpsError = 'Nie udało się pobrać lokalizacji. Sprawdź uprawnienia przeglądarki.';
                    btn.disabled = false;
                    btn.textContent = '▶ Zacznij sprzątanie';
                },
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
                    (pos) => {
                        this.lat = pos.coords.latitude;
                        this.lng = pos.coords.longitude;
                    },
                    () => {},
                    { enableHighAccuracy: false, timeout: 5000, maximumAge: 300000 }
                );
            }
        }
    }
}
</script>
@endpush
@endsection
