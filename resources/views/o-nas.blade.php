@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <section class="relative bg-slate-950 section-padding overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/pexels-pixabay-209271.jpg') }}" alt="" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/70 to-transparent"></div>
        </div>
        <div class="relative container-max mx-auto">
            <div class="max-w-2xl" data-aos="fade-right">
                <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 text-xs font-semibold rounded-full mb-6 tracking-widest uppercase">O nas</span>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tighter leading-[1.1]">Nowa firma,<br>sprawdzone doświadczenie</h1>
                <p class="text-lg text-slate-400 leading-relaxed">
                    Alluc Sp. z o.o. to świeże spojrzenie na usługi sprzątania — ale za naszą marką stoją ludzie, 
                    którzy w branży pracują od lat.
                </p>
            </div>
        </div>
    </section>

    {{-- Story --}}
    <section class="section-padding bg-white">
        <div class="container-max mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-6" data-aos="fade-right">
                    <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Kim jesteśmy?</h2>
                    <div class="space-y-6 text-slate-500 leading-relaxed">
                        <p>
                            Alluc Sp. z o.o. to firma, która powstała z prostego przekonania: 
                            <strong class="text-slate-700">usługi sprzątania mogą — i powinny — być lepsze</strong>. 
                            Lepsze pod względem jakości, komunikacji i podejścia do klienta.
                        </p>
                        <p>
                            Choć nasza marka jest nowa, nasz zespół to doświadczeni specjaliści, 
                            którzy łącznie spędzili lata w branży utrzymania czystości. Znamy standardy, 
                            wiemy, jakie są oczekiwania klientów B2B i wiemy, jak im sprostać.
                        </p>
                        <p>
                            Postanowiliśmy zbudować firmę od podstaw — bez złych nawyków, 
                            z nowoczesnym podejściem do zarządzania i jasnymi zasadami współpracy. 
                            Naszą siłą jest <strong class="text-slate-700">elastyczność, terminowość i uczciwość</strong>.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-6 space-y-6" data-aos="fade-left" data-aos-delay="150">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/10">
                        <img src="{{ asset('images/pexels-tima-miroshnichenko-6197108.jpg') }}" alt="Zespół Alluc Cleaning" class="w-full h-64 object-cover">
                    </div>
                    <div class="relative rounded-3xl overflow-hidden shadow-xl">
                        <img src="{{ asset('images/pexels-ron-lach-10567353.jpg') }}" alt="Profesjonalny sprzęt" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex items-end p-6">
                            <p class="text-white text-sm">Korzystamy wyłącznie z profesjonalnych środków czystości renomowanych marek.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="section-padding bg-slate-50">
        <div class="container-max mx-auto">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Nasze wartości</h2>
                <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">
                    Stoi za nami zespół, ale prowadzą nas zasady.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Terminowość', 'desc' => 'Słowo to słowo. Nigdy nie zawodzimy naszych klientów w kwestii terminów.'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jakość', 'desc' => 'Kompromisy w jakości? Nie u nas. Każde zlecenie realizujemy na 100%.'],
                    ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'title' => 'Komunikacja', 'desc' => 'Jasne zasady, szybkie odpowiedzi, brak nieporozumień.'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Zaangażowanie', 'desc' => 'Traktujemy Twoje biuro jak własne. Z dbałością o każdy szczegół.'],
                ] as $item)
                <div class="text-center p-6 rounded-3xl bg-white border border-slate-100 hover:shadow-xl transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="w-14 h-14 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-display text-lg font-bold text-slate-900 mb-2">{{ $item['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="section-padding bg-blue-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('images/pexels-tima-miroshnichenko-6196689.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="relative container-max mx-auto text-center" data-aos="zoom-in">
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white mb-6 tracking-tight">Przekonaj się sam</h2>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-10">
                Zamów darmową wycenę i dołącz do grona zadowolonych klientów.
            </p>
            <a href="{{ route('kontakt') }}" class="btn-primary text-base px-10 py-4">
                Zamów darmową wycenę
            </a>
        </div>
    </section>
@endsection
