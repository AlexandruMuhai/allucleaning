@extends('admin.layout')
@section('title', 'Edytuj szablon')
@section('header', 'Edytuj szablon harmonogramu')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4"><h2 class="font-display text-base font-bold text-slate-900">{{ $location->name }}</h2></div>
        <form method="POST" action="{{ route('admin.schedules.update', [$location, $template]) }}" class="space-y-5 p-6">
            @csrf @method('PUT')
            <div>
                <label for="day_of_week" class="mb-2 block text-sm font-medium text-slate-700">Dzień tygodnia</label>
                <select id="day_of_week" name="day_of_week" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    @for ($d = 1; $d <= 6; $d++)
                        <option value="{{ $d }}" {{ old('day_of_week', $template->day_of_week) == $d ? 'selected' : '' }}>{{ \Carbon\Carbon::createFromIsoFormat('N', $d)->translatedFormat('l') }}</option>
                    @endfor
                    <option value="0" {{ old('day_of_week', $template->day_of_week) == 0 ? 'selected' : '' }}>Niedziela</option>
                </select>
            </div>
            <div>
                <label for="start_time" class="mb-2 block text-sm font-medium text-slate-700">Godzina rozpoczęcia</label>
                <input id="start_time" type="time" name="start_time" value="{{ old('start_time', $template->start_time) }}" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label for="default_employee_id" class="mb-2 block text-sm font-medium text-slate-700">Domyślny pracownik</label>
                <select id="default_employee_id" name="default_employee_id" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">— brak —</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('default_employee_id', $template->default_employee_id) == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.schedules.index', $location) }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">Zapisz</button>
            </div>
        </form>
    </div>
</div>
@endsection
