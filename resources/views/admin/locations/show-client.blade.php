@extends('admin.layout')
@section('title', $location->name)
@section('header', $location->name)

@section('content')
<div class="mx-auto max-w-lg space-y-4">
    {{-- Klient NIE widzi access_code ani cleaning_instructions --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="font-display text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">Informacje</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Typ</dt><dd class="font-medium text-slate-900">{{ $location->typeLabel() }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Adres</dt><dd class="font-medium text-slate-900">{{ $location->address ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Harmonogram</dt><dd class="font-medium text-slate-900">{{ $location->schedule_info ?? '—' }}</dd></div>
            @if ($location->area_sqm)<div class="flex justify-between"><dt class="text-slate-500">Metraż</dt><dd class="font-medium text-slate-900">{{ $location->area_sqm }} m²</dd></div>@endif
            <div class="flex justify-between"><dt class="text-slate-500">Status</dt><dd><span class="inline-flex items-center gap-1 text-xs font-medium {{ $location->is_active ? 'text-emerald-600' : 'text-slate-400' }}"><span class="size-1.5 rounded-full {{ $location->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>{{ $location->is_active ? 'Aktywna' : 'Nieaktywna' }}</span></dd></div>
        </dl>
    </div>

    {{-- Ostatnie sprzątania --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h3 class="font-display text-base font-bold text-slate-900">Historia sprzątań</h3>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($location->cleanLogs()->latest('cleaned_at')->with('user')->limit(10)->get() as $log)
                <div class="flex items-center gap-3 px-5 py-3">
                    <div class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-700"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-900">{{ $log->cleaned_at->translatedFormat('d.m.Y H:i') }}</p>
                        <p class="text-xs text-slate-500">{{ $log->user?->name ?? 'Pracownik' }}{{ $log->notes ? ' — ' . $log->notes : '' }}</p>
                    </div>
                </div>
            @empty
                <p class="px-5 py-6 text-center text-sm text-slate-500">Brak wpisów o sprzątaniu.</p>
            @endforelse
        </div>
    </div>

    {{-- Strefy QR --}}
    @if ($location->passports->isNotEmpty())
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="font-display text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">Strefy QR</h3>
        <ul class="space-y-2 text-sm">
            @foreach ($location->passports as $passport)
                <li class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-2.5">
                    <span class="font-medium text-slate-900">{{ $passport->zone_name }}</span>
                    <a href="{{ route('passport.show', $passport->uuid) }}" target="_blank" class="text-xs font-semibold text-emerald-600 hover:underline">Podgląd ↗</a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
