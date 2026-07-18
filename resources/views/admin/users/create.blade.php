@extends('admin.layout')

@section('title', 'Dodaj użytkownika')
@section('header', 'Dodaj użytkownika')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-display text-base font-bold text-slate-900">Nowy użytkownik</h2>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5 p-6" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Imię i nazwisko</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('name') border-rose-400 @enderror">
                @error('name')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Adres email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
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
                        <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>{{ $role->label() }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hourly_rate" class="mb-2 block text-sm font-medium text-slate-700">Stawka godzinowa (zł/h) <span class="text-slate-400 font-normal">— opcjonalne</span></label>
                <input id="hourly_rate" type="number" step="0.01" min="0" name="hourly_rate" value="{{ old('hourly_rate') }}"
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('hourly_rate') border-rose-400 @enderror" placeholder="np. 45.00">
                @error('hourly_rate')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="photo" class="mb-2 block text-sm font-medium text-slate-700">Zdjęcie profilowe <span class="text-slate-400 font-normal">— opcjonalne</span></label>
                    <input id="photo" type="file" name="photo" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
                    @error('photo')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="krk_document" class="mb-2 block text-sm font-medium text-slate-700">Skan zaświadczenia KRK <span class="text-slate-400 font-normal">— opcjonalne</span></label>
                    <input id="krk_document" type="file" name="krk_document" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-amber-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-amber-700">
                    <p class="mt-1 text-xs text-slate-400">PDF lub zdjęcie (max 5 MB). Przesłanie dokumentu oznacza pracownika jako zweryfikowanego.</p>
                    @error('krk_document')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Hasło</label>
                <input id="password" type="password" name="password" required
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('password') border-rose-400 @enderror">
                @error('password')
                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Potwierdź hasło</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">
                    Zapisz użytkownika
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
