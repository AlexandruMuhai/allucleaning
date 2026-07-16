@extends('admin.layout')
@section('title', 'Nowy kod QR')
@section('header', 'Nowy kod QR / Strefa')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4"><h2 class="font-display text-base font-bold text-slate-900">Dane strefy</h2></div>
        <form method="POST" action="{{ route('admin.passports.store') }}" class="space-y-5 p-6">
            @csrf
            <div>
                <label for="location_id" class="mb-2 block text-sm font-medium text-slate-700">Lokalizacja</label>
                <select id="location_id" name="location_id" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('location_id') border-rose-400 @enderror">
                    <option value="">Wybierz lokalizację…</option>
                    @foreach ($locations as $loc)
                        <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }} ({{ $loc->typeLabel() }})</option>
                    @endforeach
                </select>
                @error('location_id')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="zone_name" class="mb-2 block text-sm font-medium text-slate-700">Nazwa strefy</label>
                <input id="zone_name" name="zone_name" value="{{ old('zone_name') }}" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. Główny QR, Toaleta Męska, Kuchnia 1 piętro">
                @error('zone_name')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="next_scheduled_clean" class="mb-2 block text-sm font-medium text-slate-700">Następne sprzątanie</label>
                <input id="next_scheduled_clean" type="datetime-local" name="next_scheduled_clean" value="{{ old('next_scheduled_clean') }}" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.passports.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">Zapisz</button>
            </div>
        </form>
    </div>
</div>
@endsection
