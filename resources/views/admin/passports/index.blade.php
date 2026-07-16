@extends('admin.layout')
@section('title', 'Paszporty QR')
@section('header', 'Kody QR / Strefy')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">Łącznie: <span class="font-semibold text-slate-700">{{ $passports->total() }}</span></p>
        <a href="{{ route('admin.passports.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Dodaj kod QR
        </a>
    </div>
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50"><tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Strefa</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Lokalizacja</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Następne sprzątanie</th>
                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Akcje</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($passports as $passport)
                    <tr class="transition-colors hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.passports.show', $passport) }}" class="text-sm font-semibold text-slate-900 hover:text-emerald-600">{{ $passport->zone_name }}</a>
                            <p class="text-xs text-slate-400">{{ substr($passport->uuid, 0, 8) }}…</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $passport->location->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $passport->next_scheduled_clean?->translatedFormat('d.m.Y H:i') ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.passports.show', $passport) }}" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-emerald-50 hover:text-emerald-600" title="Szczegóły + QR">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.passports.edit', $passport) }}" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-blue-50 hover:text-blue-600" title="Edytuj">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.passports.destroy', $passport) }}" onsubmit="return confirm('Usunąć?');">@csrf @method('DELETE')
                                    <button type="submit" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-rose-50 hover:text-rose-600"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Brak kodów QR.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $passports->links() }}</div>
</div>
@endsection
