@extends('admin.layout')
@section('title', 'Harmonogram')
@section('header', 'Harmonogram: ' . $location->name)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">Szablony harmonogramu dla: <span class="font-semibold text-slate-900">{{ $location->name }}</span></p>
        <a href="{{ route('admin.schedules.create', $location) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Dodaj dzień sprzątania
        </a>
    </div>

    @if ($templates->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-slate-500">Brak ustawionych szablonów harmonogramu.</p>
            <p class="text-xs text-slate-400 mt-1">Dodaj dzień sprzątania, aby system automatycznie generował zlecenia.</p>
        </div>
    @else
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50"><tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Dzień tygodnia</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Godzina startu</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Domyślny pracownik</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Akcje</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($templates as $tpl)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $tpl->dayOfWeekLabel() }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ \Carbon\Carbon::parse($tpl->start_time)->format('H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $tpl->defaultEmployee?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.schedules.edit', [$location, $tpl]) }}" class="rounded-lg p-2 text-slate-500 hover:bg-blue-50 hover:text-blue-600"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                    <form method="POST" action="{{ route('admin.schedules.destroy', [$location, $tpl]) }}" onsubmit="return confirm('Usunąć?');">@csrf @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-slate-500 hover:bg-rose-50 hover:text-rose-600"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('admin.locations.show', $location) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">← Wróć do lokalizacji</a>
</div>
@endsection
