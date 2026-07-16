@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <section class="relative bg-slate-950 section-padding overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/pexels-cottonbro-5483052.jpg') }}" alt="" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/70 to-transparent"></div>
        </div>
        <div class="relative container-max mx-auto">
            <div class="max-w-2xl" data-aos="fade-right">
                <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 text-xs font-semibold rounded-full mb-6 tracking-widest uppercase">Kontakt</span>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tighter leading-[1.1]">Zamów darmową<br>wycenę</h1>
                <p class="text-lg text-slate-400 leading-relaxed">
                    Wypełnij formularz, a nasz specjalista skontaktuje się z Tobą w ciągu 2 godzin roboczych. 
                    Wycena jest bezpłatna i niezobowiązująca.
                </p>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="section-padding bg-white">
        <div class="container-max mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Contact Form --}}
                <div class="lg:col-span-2" data-aos="fade-right">
                    @if (session('success'))
                        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 flex items-start gap-3" data-aos="zoom-in">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-semibold">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('kontakt.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Imię i nazwisko <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full rounded-xl border-slate-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors @error('name') border-red-500 @enderror"
                                    placeholder="Jan Kowalski">
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="company_name" class="block text-sm font-semibold text-slate-700 mb-2">Nazwa firmy</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}"
                                    class="w-full rounded-xl border-slate-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors @error('company_name') border-red-500 @enderror"
                                    placeholder="ABC Sp. z o.o.">
                                @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Adres e-mail <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full rounded-xl border-slate-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="jan@firma.pl">
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Telefon <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="w-full rounded-xl border-slate-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors @error('phone') border-red-500 @enderror"
                                    placeholder="+48 123 456 789">
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="service_type" class="block text-sm font-semibold text-slate-700 mb-2">Rodzaj usługi <span class="text-red-500">*</span></label>
                            <select name="service_type" id="service_type" required
                                class="w-full rounded-xl border-slate-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors @error('service_type') border-red-500 @enderror">
                                <option value="">Wybierz rodzaj usługi...</option>
                                @foreach ($serviceTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('service_type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">Wiadomość</label>
                            <textarea name="message" id="message" rows="5"
                                class="w-full rounded-xl border-slate-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors @error('message') border-red-500 @enderror"
                                placeholder="Opisz swoje potrzeby — metraż, częstotliwość sprzątania, specjalne wymagania...">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-primary text-base px-10 py-4">
                            Wyślij zapytanie
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Contact Info Sidebar --}}
                <div class="lg:col-span-1" data-aos="fade-left" data-aos-delay="200">
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 sticky top-24">
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-6">Dane kontaktowe</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-medium">E-mail</p>
                                    <a href="mailto:biuro@allucleaning.pl" class="text-slate-900 font-semibold hover:text-emerald-600 transition-colors">biuro@allucleaning.pl</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-medium">Telefon</p>
                                    <a href="tel:+48123456789" class="text-slate-900 font-semibold hover:text-emerald-600 transition-colors">+48 123 456 789</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-medium">Godziny pracy</p>
                                    <p class="text-slate-900 font-semibold">Pon–Pt: 8:00–18:00</p>
                                    <p class="text-slate-500 text-sm">Sob: 9:00–14:00</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-8 border-slate-200">

                        <h4 class="font-display text-lg font-bold text-slate-900 mb-4">Dane firmy</h4>
                        <div class="space-y-1.5 text-sm text-slate-500">
                            <p class="font-semibold text-slate-700">Alluc Sp. z o.o.</p>
                            <p>13</p>
                            <p>Krokowo</p>
                            <p>11-320 Olsztyn</p>
                            <p class="pt-2 text-slate-400">NIP: 739-403-54-54</p>
                            <p class="text-slate-400">REGON: 544970349</p>
                            <p class="text-slate-400">KRS: 0001246819</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
