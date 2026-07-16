<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paszport Czystości — {{ $passport->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Urbanist:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-full bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="mx-auto flex min-h-full max-w-md flex-col px-4 py-6">

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Nagłówek --}}
        <header class="mb-6 text-center">
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Cyfrowy Paszport Czystości</p>
            <h1 class="font-display text-2xl font-extrabold text-slate-900">{{ $passport->name }}</h1>
            @if ($passport->location)
                <p class="mt-1 text-sm text-slate-500">{{ $passport->location->name }}</p>
            @endif
        </header>

        {{-- Status czystości --}}
        <section class="mb-6 rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-center text-white shadow-lg shadow-emerald-600/20">
            <div class="mx-auto mb-3 flex size-16 items-center justify-center rounded-full bg-white/20">
                <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            @if ($lastClean)
                <p class="font-display text-xl font-extrabold">Czysto ✦</p>
                <p class="mt-1 text-sm text-emerald-50">
                    Ostatnio sprzątane:
                    <span class="font-semibold">{{ $lastClean->cleaned_at->translatedFormat('d.m.Y') }} o {{ $lastClean->cleaned_at->format('H:i') }}</span>
                </p>
                @if ($lastClean->user)
                    <p class="text-sm text-emerald-50">przez {{ $lastClean->user->name }}</p>
                @endif
            @else
                <p class="font-display text-xl font-extrabold">Oczekuje na sprzątanie</p>
                <p class="mt-1 text-sm text-emerald-50">To miejsce nie zostało jeszcze oznaczone jako posprzątane.</p>
            @endif

            @if ($passport->next_scheduled_clean)
                <div class="mt-4 inline-block rounded-full bg-white/15 px-4 py-1.5 text-xs font-medium">
                    Planowane sprzątanie: {{ $passport->next_scheduled_clean->translatedFormat('d.m.Y H:i') }}
                </div>
            @endif
        </section>

        {{-- Zgłoś problem --}}
        <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm" x-data="{ open: false }">
            <button @click="open = !open" class="flex w-full items-center justify-between text-left">
                <span class="flex items-center gap-2 font-display text-base font-bold text-slate-900">
                    <svg class="size-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5 19h14a2 2 0 001.94-2.53l-7-12a2 2 0 00-3.48 0l-7 12A2 2 0 005 19z"/></svg>
                    Zgłoś problem
                </span>
                <svg class="size-5 text-slate-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <form method="POST" action="{{ route('passport.issue', $passport->uuid) }}" enctype="multipart/form-data" x-show="open" x-cloak class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Twoje imię (opcjonalnie)</label>
                    <input type="text" name="reporter_name" class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Opis problemu</label>
                    <textarea name="description" rows="3" required class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. brak mydła, rozlana woda"></textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Dodaj zdjęcie</label>
                    <input type="file" name="photo" accept="image/*" capture="environment" class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
                </div>
                <button type="submit" class="w-full rounded-xl bg-rose-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-500/25 transition-all hover:bg-rose-600 active:scale-[0.98]">
                    Wyślij zgłoszenie
                </button>
            </form>
        </section>

        {{-- Ostatnie sprzątania --}}
        @if ($passport->cleanLogs->isNotEmpty())
            <section class="mb-6">
                <h2 class="mb-3 px-1 font-display text-sm font-bold uppercase tracking-wider text-slate-500">Ostatnie sprzątania</h2>
                <div class="space-y-2">
                    @foreach ($passport->cleanLogs as $log)
                        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            @if ($log->photo_path)
                                <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Zdjęcie" class="size-12 rounded-lg object-cover">
                            @else
                                <div class="flex size-12 items-center justify-center rounded-lg bg-slate-100 text-slate-400">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $log->cleaned_at->translatedFormat('d.m.Y H:i') }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $log->user->name ?? 'Pracownik' }}{{ $log->notes ? ' — ' . $log->notes : '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <footer class="mt-auto pt-4 text-center text-xs text-slate-400">
            Alluc Cleaning — profesjonalna czystość
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
