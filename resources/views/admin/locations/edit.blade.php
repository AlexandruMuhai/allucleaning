@extends('admin.layout')
@section('title', 'Edytuj lokalizację')
@section('header', 'Edytuj: ' . $location->name)

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-display text-base font-bold text-slate-900">Dane lokalizacji</h2>
        </div>
        <form method="POST" action="{{ route('admin.locations.update', $location) }}" class="space-y-5 p-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nazwa</label>
                    <input id="name" name="name" value="{{ old('name', $location->name) }}" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label for="type" class="mb-2 block text-sm font-medium text-slate-700">Typ</label>
                    <select id="type" name="type" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="office" {{ old('type', $location->type) === 'office' ? 'selected' : '' }}>Biuro</option>
                        <option value="staircase" {{ old('type', $location->type) === 'staircase' ? 'selected' : '' }}>Klatka schodowa</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="address" class="mb-2 block text-sm font-medium text-slate-700">Adres</label>
                <input id="address" name="address" value="{{ old('address', $location->address) }}" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label for="client_id" class="mb-2 block text-sm font-medium text-slate-700">Właściciel / Klient</label>
                <select id="client_id" name="client_id" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">— brak —</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $location->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="area_sqm" class="mb-2 block text-sm font-medium text-slate-700">Metraż (m²)</label>
                    <input id="area_sqm" type="number" name="area_sqm" value="{{ old('area_sqm', $location->area_sqm) }}" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label for="schedule_info" class="mb-2 block text-sm font-medium text-slate-700">Harmonogram</label>
                    <input id="schedule_info" name="schedule_info" value="{{ old('schedule_info', $location->schedule_info) }}" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
            <div>
                <label for="access_code" class="mb-2 block text-sm font-medium text-slate-700">Kod dostępu</label>
                <input id="access_code" name="access_code" value="{{ old('access_code', $location->access_code) }}" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label for="cleaning_instructions" class="mb-2 block text-sm font-medium text-slate-700">Instrukcje sprzątania</label>
                <textarea id="cleaning_instructions" name="cleaning_instructions" rows="4" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('cleaning_instructions', $location->cleaning_instructions) }}</textarea>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Przypisani pracownicy</label>
                <div class="space-y-2 rounded-xl border border-slate-200 p-4 max-h-40 overflow-y-auto">
                    @forelse ($employees as $emp)
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="employees[]" value="{{ $emp->id }}" {{ in_array($emp->id, $assigned) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            {{ $emp->name }}
                        </label>
                    @empty
                        <p class="text-xs text-slate-400">Brak pracowników w systemie.</p>
                    @endforelse
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.locations.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">Zapisz</button>
            </div>
        </form>
    </div>
</div>
@endsection
