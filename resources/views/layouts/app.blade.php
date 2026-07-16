<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Alluc Cleaning — profesjonalne usługi sprzątania dla biur, lokali użytkowych i wspólnot mieszkaniowych. Sprawdź naszą ofertę.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Alluc Cleaning' }} — Profesjonalne Sprzątanie B2B</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Urbanist:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    {{-- Navigation --}}
    <nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100">
        <div class="container-max mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Alluc Cleaning" class="h-14 w-auto">
                </a>

                <div class="hidden lg:flex items-center">
                    <a href="{{ route('home') }}" class="relative px-5 py-2 text-sm font-semibold tracking-wide {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-500 hover:text-slate-900' }} transition-colors duration-200">
                        Strona Główna
                        @if(request()->routeIs('home'))
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('oferta') }}" class="relative px-5 py-2 text-sm font-semibold tracking-wide {{ request()->routeIs('oferta') ? 'text-emerald-600' : 'text-slate-500 hover:text-slate-900' }} transition-colors duration-200">
                        Oferta
                        @if(request()->routeIs('oferta'))
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('o-nas') }}" class="relative px-5 py-2 text-sm font-semibold tracking-wide {{ request()->routeIs('o-nas') ? 'text-emerald-600' : 'text-slate-500 hover:text-slate-900' }} transition-colors duration-200">
                        O Nas
                        @if(request()->routeIs('o-nas'))
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </a>

                    <div class="w-px h-5 bg-slate-200 mx-3"></div>

                    <a href="tel:+48123456789" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +48 123 456 789
                    </a>

                    <a href="{{ route('kontakt') }}" class="ml-2 btn-primary text-sm py-2.5 px-6">Zamów Wycenę</a>
                </div>

                {{-- Mobile --}}
                <div class="flex lg:hidden items-center gap-3">
                    <a href="tel:+48123456789" class="p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </a>
                    <button @click="open = !open" class="p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div x-show="open" x-transition x-cloak class="lg:hidden pb-5 pt-1 border-t border-slate-100">
                <div class="space-y-1 mt-3">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        @if(request()->routeIs('home'))<span class="w-1.5 h-1.5 bg-emerald-600 rounded-full mr-3"></span>@endif
                        Strona Główna
                    </a>
                    <a href="{{ route('oferta') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('oferta') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        @if(request()->routeIs('oferta'))<span class="w-1.5 h-1.5 bg-emerald-600 rounded-full mr-3"></span>@endif
                        Oferta
                    </a>
                    <a href="{{ route('o-nas') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('o-nas') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} transition-colors">
                        @if(request()->routeIs('o-nas'))<span class="w-1.5 h-1.5 bg-emerald-600 rounded-full mr-3"></span>@endif
                        O Nas
                    </a>
                </div>
                <div class="mt-4 px-4">
                    <a href="{{ route('kontakt') }}" class="flex items-center justify-center w-full btn-primary text-sm py-3">Zamów Wycenę</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Spacer for fixed nav --}}
    <div class="h-20"></div>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-950 text-slate-400">
        <div class="container-max mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-5">
                        <img src="{{ asset('images/logo.png') }}" alt="Alluc Cleaning" class="h-9 w-auto brightness-200 invert opacity-80">
                    </a>
                    <p class="text-sm leading-relaxed text-slate-500">
                        Profesjonalne usługi sprzątania dla firm i instytucji. Czystość, na którą możesz liczyć.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-display font-semibold mb-5 tracking-wide text-sm uppercase">Nawigacja</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Strona Główna</a></li>
                        <li><a href="{{ route('oferta') }}" class="hover:text-emerald-400 transition-colors">Oferta</a></li>
                        <li><a href="{{ route('o-nas') }}" class="hover:text-emerald-400 transition-colors">O Nas</a></li>
                        <li><a href="{{ route('kontakt') }}" class="hover:text-emerald-400 transition-colors">Kontakt</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-display font-semibold mb-5 tracking-wide text-sm uppercase">Usługi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('oferta') }}" class="hover:text-emerald-400 transition-colors">Sprzątanie Biur</a></li>
                        <li><a href="{{ route('oferta') }}" class="hover:text-emerald-400 transition-colors">Klatki Schodowe</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-display font-semibold mb-5 tracking-wide text-sm uppercase">Kontakt</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <a href="mailto:biuro@allucleaning.pl" class="hover:text-emerald-400 transition-colors">biuro@allucleaning.pl</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <a href="tel:+48123456789" class="hover:text-emerald-400 transition-colors">+48 123 456 789</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-14 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-600">
                    <div class="text-center md:text-left">
                        <p>&copy; {{ date('Y') }} Alluc Sp. z o.o. &mdash; Wszelkie prawa zastrzeżone.</p>
                        <p class="mt-1">NIP: 739-403-54-54 &bull; REGON: 544970349 &bull; KRS: 0001246819</p>
                        <p class="mt-1">13, Krokowo, 11-320 Olsztyn</p>
                    </div>
                    <p class="shrink-0 font-medium">allucleaning.pl</p>
                </div>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
