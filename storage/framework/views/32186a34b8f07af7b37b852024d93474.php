<?php $__env->startSection('content'); ?>
    
    <section class="relative bg-slate-950 section-padding overflow-hidden">
        <div class="absolute inset-0">
            <img src="<?php echo e(asset('images/pexels-ron-lach-10567353.jpg')); ?>" alt="" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/70 to-transparent"></div>
        </div>
        <div class="relative container-max mx-auto">
            <div class="max-w-2xl" data-aos="fade-right">
                <span class="inline-block px-4 py-1.5 bg-emerald-600/20 text-emerald-400 text-xs font-semibold rounded-full mb-6 tracking-widest uppercase">Oferta</span>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tighter leading-[1.1]">Usługi dopasowane<br>do Twoich potrzeb</h1>
                <p class="text-lg text-slate-400 leading-relaxed">
                    Kompleksowe usługi sprzątania biur oraz klatek schodowych i wspólnot mieszkaniowych. Każdą realizację dopasowujemy indywidualnie.
                </p>
            </div>
        </div>
    </section>

    
    <section id="biura" class="section-padding bg-white relative overflow-hidden">
        
        <svg class="absolute top-0 right-0 w-96 h-96 text-emerald-50 opacity-80 -translate-y-1/4 translate-x-1/4" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M44.7,-76.4C58.8,-69.2,71.8,-58.9,79.6,-45.8C87.4,-32.6,90,-16.3,88.4,-0.9C86.8,14.5,81,29,72.1,41.2C63.2,53.4,51.2,63.3,38,70.1C24.8,77,11,80.8,-2.8,83.6C-16.6,86.5,-30.3,88.4,-42.5,83C-54.8,77.6,-65.6,65,-72.8,50.9C-80,36.8,-83.7,21.2,-84.3,5.3C-85,-10.7,-82.6,-26.9,-74.5,-39.5C-66.3,-52.1,-52.3,-61.1,-38.3,-68.4C-24.3,-75.7,-10.2,-81.3,3.3,-87C16.7,-92.7,30.7,-83.5,44.7,-76.4Z" transform="translate(100 100)" />
        </svg>

        <div class="container-max mx-auto relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-5" data-aos="fade-right">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Sprzątanie Biur</h2>
                    <p class="text-slate-500 text-lg mb-8 leading-relaxed">
                        Zadbamy o czystość Twojego biura, abyś mógł skupić się na prowadzeniu biznesu. Obsługujemy małe i średnie biura w elastycznym trybie.
                    </p>
                    <ul class="space-y-4">
                        <?php $__currentLoopData = ['Sprzątanie codzienne lub kilka razy w tygodniu — Ty ustalasz harmonogram', 'Mycie podłóg, odkurzanie, czyszczenie łazienek i kuchni', 'Opróżnianie koszy, uzupełnianie środków higieny', 'Prace realizowane po godzinach pracy biura — bez zakłóceń', 'Profesjonalne środki czystości w cenie usługi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-slate-600"><?php echo e($item); ?></span>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                
                <div class="lg:col-span-7 lg:pl-8" data-aos="fade-left" data-aos-delay="150">
                    <div class="relative">
                        <div class="rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/10">
                            <img src="<?php echo e(asset('images/pexels-cottonbro-5483052.jpg')); ?>" alt="Sprzątanie biur" class="w-full h-80 lg:h-[28rem] object-cover">
                        </div>
                        
                        <div class="absolute -bottom-6 -left-4 lg:-left-8 glass rounded-2xl p-5 max-w-[200px] shadow-xl" data-aos="zoom-in" data-aos-delay="300">
                            <span class="text-emerald-600 font-display font-bold text-sm">01</span>
                            <p class="text-slate-900 font-semibold text-sm mt-1">Bezpłatna wycena</p>
                        </div>
                        <div class="absolute -bottom-6 left-40 glass rounded-2xl p-5 max-w-[200px] shadow-xl hidden sm:block" data-aos="zoom-in" data-aos-delay="400">
                            <span class="text-emerald-600 font-display font-bold text-sm">02</span>
                            <p class="text-slate-900 font-semibold text-sm mt-1">Indywidualna oferta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="klatki" class="section-padding bg-slate-50 relative overflow-hidden">
        <div class="container-max mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="relative">
                        <div class="rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/10" style="clip-path: polygon(0 0, 100% 0, 100% 85%, 85% 100%, 0 100%);">
                            <img src="<?php echo e(asset('images/pexels-sliceisop-4737704.jpg')); ?>" alt="Klatki schodowe" class="w-full h-80 lg:h-[30rem] object-cover">
                        </div>
                        
                        <div class="absolute -bottom-4 right-4 lg:-right-4 bg-emerald-600 text-white rounded-2xl px-6 py-4 shadow-xl shadow-emerald-600/20" data-aos="zoom-in" data-aos-delay="400">
                            <p class="font-display font-extrabold text-2xl">od 180 zł</p>
                            <p class="text-emerald-100 text-xs">netto / klatka</p>
                        </div>
                    </div>
                </div>

                
                <div class="lg:col-span-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="w-12 h-12 bg-blue-900 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Klatki Schodowe i Wspólnoty</h2>
                    <p class="text-slate-500 text-lg mb-8 leading-relaxed">
                        Wspólnoty mieszkaniowe i zarządcy nieruchomości ufają nam, bo wiemy, jak ważne jest utrzymanie czystości w częściach wspólnych budynku.
                    </p>
                    <ul class="space-y-4 mb-10">
                        <?php $__currentLoopData = ['Mycie klatek schodowych, wind i korytarzy', 'Czyszczenie domofonów, poręczy i drzwi wejściowych', 'Usuwanie graffiti i niepożądanych naklejek', 'Sprzątanie piwnic, strychów i wózkowni', 'Zimą — odśnieżanie wejść i chodników']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-slate-600"><?php echo e($item); ?></span>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    
                    <div class="bg-blue-900 rounded-2xl p-6 text-white">
                        <h3 class="font-display text-lg font-bold mb-4">Współpraca ze wspólnotami</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <?php $__currentLoopData = ['Przejrzyste stawki', 'Brak ukrytych kosztów', 'Dedykowany opiekun', 'Elastyczne płatności']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="text-slate-300 text-sm"><?php echo e($feat); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <a href="<?php echo e(route('kontakt')); ?>" class="btn-primary mt-6 text-sm py-2.5 px-5">Zapytaj o ofertę</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-14 bg-white border-y border-slate-100">
        <div class="container-max mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <?php $__currentLoopData = [
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => '24h', 'label' => 'Gwarancja poprawek'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'value' => '48h', 'label' => 'Szybki start'],
                    ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'value' => '0 zł', 'label' => 'Brak ryzyka na start'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'value' => '10 lat+', 'label' => 'Doświadczony zespół'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-center" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 80); ?>">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-emerald-100">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($item['icon']); ?>"/></svg>
                    </div>
                    <p class="font-display font-bold text-slate-900 text-lg"><?php echo e($item['value']); ?></p>
                    <p class="text-sm text-slate-500"><?php echo e($item['label']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="cennik" class="section-padding bg-gradient-to-br from-slate-50 via-white to-slate-100">
        <div class="container-max mx-auto">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-1.5 bg-emerald-600/10 text-emerald-700 text-xs font-semibold rounded-full mb-4 tracking-widest uppercase">Ceny promocyjne na start</span>
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Przykładowy Cennik</h2>
                <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">
                    Konkurencyjne stawki, utrzymując najwyższą jakość — zależy nam na budowaniu długofalowych relacji.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                
                <div class="glass rounded-3xl p-8 border border-white/40 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-4">Sprzątanie Biur</h3>
                    <div class="mb-6">
                        <span class="font-display text-4xl font-extrabold text-blue-900">od 45 zł</span>
                        <span class="text-sm text-slate-500 ml-1">netto / roboczogodzina</span>
                        <p class="text-sm text-slate-400 mt-1">lub od 3,50 zł netto / m²</p>
                    </div>
                    <hr class="border-slate-200/50 mb-6">
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-slate-600">Własny sprzęt i profesjonalna chemia w cenie</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-slate-600">Elastyczny grafik — rano, wieczór, weekendy</span>
                        </li>
                    </ul>
                    <a href="<?php echo e(route('kontakt')); ?>" class="w-full btn-primary text-center text-sm py-3">Zamów wycenę</a>
                </div>

                
                <div class="glass rounded-3xl p-8 border-2 border-blue-900/30 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 relative" data-aos="fade-up" data-aos-delay="100">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-semibold px-4 py-1.5 rounded-full">Polecane</span>
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-4">Klatki Schodowe (Wspólnoty)</h3>
                    <div class="mb-6">
                        <span class="font-display text-4xl font-extrabold text-blue-900">od 180 zł</span>
                        <span class="text-sm text-slate-500 ml-1">netto / klatka schodowa</span>
                        <p class="text-sm text-slate-400 mt-1">przy stałej obsłudze</p>
                    </div>
                    <hr class="border-slate-200/50 mb-6">
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-slate-600">Regularne mycie, omiatanie pajęczyn, dbałość o parter</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-slate-600">Atrakcyjne pakiety przy kilku klatkach</span>
                        </li>
                    </ul>
                    <a href="<?php echo e(route('kontakt')); ?>" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold text-center text-sm py-3 rounded-xl transition-all hover:-translate-y-0.5">
                        Zapytaj o ofertę
                    </a>
                </div>
            </div>

            <p class="mt-10 text-center text-sm text-slate-400 max-w-3xl mx-auto" data-aos="fade-up">
                *Powyższy cennik ma charakter poglądowy i nie stanowi oferty handlowej. Każde zlecenie wyceniamy indywidualnie podczas darmowych oględzin.
            </p>
        </div>
    </section>

    
    <section class="section-padding bg-slate-50">
        <div class="container-max mx-auto text-center" data-aos="zoom-in">
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Nie znalazłeś interesującej Cię usługi?</h2>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10">
                Skontaktuj się z nami — przygotujemy indywidualną ofertę dopasowaną do Twoich potrzeb.
            </p>
            <a href="<?php echo e(route('kontakt')); ?>" class="btn-primary text-base px-10 py-4">Skontaktuj się z nami</a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/oferta.blade.php ENDPATH**/ ?>