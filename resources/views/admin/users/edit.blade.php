@extends('admin.layout')

@section('title', 'Edytuj użytkownika')
@section('header', 'Edytuj użytkownika')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-display text-base font-bold text-slate-900">{{ $user->name }}</h2>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5 p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Imię i nazwisko</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('name') border-rose-400 @enderror">
                @error('name')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Adres email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('email') border-rose-400 @enderror">
                @error('email')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="mb-2 block text-sm font-medium text-slate-700">Rola</label>
                <select id="role" name="role" required
                        class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('role') border-rose-400 @enderror">
                    @foreach ($roles as $role)
                        <option value="{{ $role->value }}" {{ old('role', $user->role->value) == $role->value ? 'selected' : '' }}>{{ $role->label() }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hourly_rate" class="mb-2 block text-sm font-medium text-slate-700">Stawka godzinowa (zł/h) <span class="text-slate-400 font-normal">— opcjonalne</span></label>
                <input id="hourly_rate" type="number" step="0.01" min="0" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}"
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('hourly_rate') border-rose-400 @enderror" placeholder="np. 45.00">
                @error('hourly_rate')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="photo" class="mb-2 block text-sm font-medium text-slate-700">Zdjęcie profilowe</label>
                    @if ($user->photo)
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ $user->photo_url }}" class="size-12 rounded-xl object-cover ring-2 ring-slate-200">
                            <span class="text-xs text-slate-400">Zostaw puste, aby zachować obecne.</span>
                        </div>
                    @endif
                    <input id="photo" type="file" name="photo" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
                    @error('photo')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="krk_document" class="mb-2 block text-sm font-medium text-slate-700">Skan zaświadczenia KRK</label>
                    @if ($user->krk_document_path)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $user->krk_document_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Aktualny skan KRK
                            </a>
                        </div>
                    @endif
                    <input id="krk_document" type="file" name="krk_document" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-amber-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-amber-700">
                    @error('krk_document')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ($user->role->value === 'pracownik')
            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <input type="hidden" name="krk_verified" value="0">
                <input type="checkbox" id="krk_verified" name="krk_verified" value="1" {{ $user->krk_verified ? 'checked' : '' }}
                       class="size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <label for="krk_verified" class="text-sm font-medium text-slate-700">Pracownik zweryfikowany (KRK)</label>
            </div>
            @endif

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Nowe hasło</label>
                <input id="password" type="password" name="password"
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('password') border-rose-400 @enderror">
                <p class="mt-1.5 text-xs text-slate-500">Zostaw puste, aby zachować obecne hasło.</p>
                @error('password')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Potwierdź nowe hasło</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">
                    Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
