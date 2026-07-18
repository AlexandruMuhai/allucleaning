@extends('admin.layout')

@section('title', 'Użytkownicy')
@section('header', 'Zarządzanie użytkownikami')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">Łącznie użytkowników: <span class="font-semibold text-slate-700">{{ $users->total() }}</span></p>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 hover:shadow-emerald-500/30 active:scale-[0.98]">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Dodaj użytkownika
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Użytkownik</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Rola</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Data utworzenia</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="transition-colors hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-3">
                                @if ($user->photo)
                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="size-9 rounded-full object-cover ring-2 ring-slate-200">
                                @else
                                    <div class="flex size-9 items-center justify-center rounded-full bg-slate-900 font-semibold text-white">
                                        {{ $user->initial }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @include('admin.users.partials.role-badge', ['role' => $user->role])
                                @if ($user->role->value === 'pracownik')
                                    @if ($user->isKrkVerified())
                                        <span class="inline-flex size-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-600" title="KRK zweryfikowany">
                                            <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                    @else
                                        <span class="inline-flex size-5 items-center justify-center rounded-full bg-slate-100 text-slate-400" title="KRK niezweryfikowany">
                                            <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-blue-50 hover:text-blue-600" title="Edytuj">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-rose-50 hover:text-rose-600" title="Usuń">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Brak użytkowników.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
