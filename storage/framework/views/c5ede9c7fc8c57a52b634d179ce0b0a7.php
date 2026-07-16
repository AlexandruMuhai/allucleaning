<?php $__env->startSection('content'); ?>
    
    <section class="relative overflow-hidden min-h-[92vh] flex items-center">
        
        <div id="particle-canvas" class="absolute inset-0 z-0"></div>

        
        <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-white via-white/50 to-transparent z-[1] pointer-events-none"></div>

        <div class="relative z-[2] section-padding w-full">
            <div class="container-max mx-auto">
                <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-delay="100">
                    <h1 class="font-display text-6xl sm:text-7xl lg:text-[5.5rem] font-extrabold text-slate-900 leading-[1.0] tracking-tighter mb-8">
                        Sprzątamy za Ciebie.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-900 via-cyan-800 to-teal-700">Ty zajmujesz się biznesem.</span>
                    </h1>

                    <p class="text-xl text-slate-700 max-w-2xl mx-auto leading-relaxed mb-12">
                        Profesjonalne usługi sprzątania biur i wspólnot mieszkaniowych 
                        w Olsztynie i okolicach. Bez umów na lata — zacznij od okresu próbnego.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center mb-16">
                        <a href="<?php echo e(route('kontakt')); ?>" class="group relative inline-flex items-center justify-center px-10 py-5 bg-emerald-600 text-white text-lg font-bold rounded-2xl shadow-xl shadow-emerald-600/30 hover:shadow-2xl hover:shadow-emerald-500/40 hover:bg-emerald-500 hover:-translate-y-1 hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-emerald-400/0 via-white/15 to-emerald-400/0 translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-700 ease-out"></span>
                            <span class="relative flex items-center gap-3">
                                Zamów darmową wycenę
                                <svg class="w-5 h-5 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                        <a href="<?php echo e(route('oferta')); ?>" class="group relative inline-flex items-center justify-center px-10 py-5 rounded-2xl font-bold text-lg text-white bg-blue-600 shadow-xl shadow-blue-600/30 hover:bg-blue-500 hover:shadow-2xl hover:shadow-blue-500/40 hover:-translate-y-1 hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 overflow-hidden">
                            <span class="pointer-events-none absolute inset-0">
                                <span class="absolute -left-2 top-3 size-6 rounded-full border-2 border-white/40 bg-white/10"></span>
                                <span class="absolute left-8 bottom-2 size-3 rounded-full border border-white/30 bg-white/5"></span>
                                <span class="absolute right-6 top-4 size-4 rounded-full border-2 border-white/40 bg-white/10"></span>
                                <span class="absolute -right-1 bottom-5 size-7 rounded-full border border-white/30 bg-white/5"></span>
                                <span class="absolute left-1/2 bottom-1 size-2 rounded-full border border-white/40 bg-white/10"></span>
                            </span>
                            <span class="relative flex items-center gap-2">
                                Zobacz ofertę
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>
                    </div>

                    
                    <div class="flex flex-wrap justify-center gap-8 sm:gap-14" data-aos="fade-up" data-aos-delay="300">
                        <div class="text-center">
                            <p class="font-display font-extrabold text-3xl text-slate-900">48<span class="text-emerald-600">h</span></p>
                            <p class="text-slate-600 text-sm mt-1">Szybki start</p>
                        </div>
                        <div class="w-px bg-slate-900/10 hidden sm:block"></div>
                        <div class="text-center">
                            <p class="font-display font-extrabold text-3xl text-slate-900">24<span class="text-emerald-600">h</span></p>
                            <p class="text-slate-600 text-sm mt-1">Gwarancja poprawek</p>
                        </div>
                        <div class="w-px bg-slate-900/10 hidden sm:block"></div>
                        <div class="text-center">
                            <p class="font-display font-extrabold text-3xl text-slate-900">0<span class="text-emerald-600"> zł</span></p>
                            <p class="text-slate-600 text-sm mt-1">Wycena bez zobowiązań</p>
                        </div>
                        <div class="w-px bg-slate-900/10 hidden sm:block"></div>
                        <div class="text-center">
                            <p class="font-display font-extrabold text-3xl text-slate-900">10+</p>
                            <p class="text-slate-600 text-sm mt-1">Lat doświadczenia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-padding bg-white">
        <div class="container-max mx-auto">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Dlaczego firmy wybierają Alluc?</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">
                    Stawiamy na transparentność, jakość i budowanie długoterminowych relacji z naszymi klientami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-500" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-14 h-14 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Doświadczony Zespół</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Nasi pracownicy to specjaliści z wieloletnim doświadczeniem w branży. Regularnie szkolimy zespół.</p>
                </div>

                <div class="text-center p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Brak Ryzyka na Start</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Zacznijmy od okresu próbnego. Nie wymagamy długoterminowych umów od pierwszego dnia.</p>
                </div>

                <div class="text-center p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Gwarancja 24h</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Jeśli w ciągu 24h zauważysz niedociągnięcia — poprawimy je bezpłatnie. Twoja satysfakcja to nasz priorytet.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-padding bg-slate-50">
        <div class="container-max mx-auto">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Nasze Usługi</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">Kompleksowe rozwiązania sprzątania dopasowane do Twojego biznesu.</p>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-6 gap-5" data-aos="fade-up" data-aos-delay="100">
                
                <div class="md:col-span-4 bento-card bg-white shadow-sm border border-slate-100">
                    <div class="relative h-56 overflow-hidden">
                        <img src="<?php echo e(asset('images/pexels-cottonbro-5483052.jpg')); ?>" alt="Sprzątanie biur" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">BIURA</span>
                    </div>
                    <div class="p-8">
                        <h3 class="font-display text-2xl font-bold text-slate-900 mb-3">Sprzątanie Biur</h3>
                        <p class="text-slate-500 mb-6 leading-relaxed">Małe i średnie biura — codziennie lub kilka razy w tygodniu. Elastyczne harmonogramy dopasowane do godzin pracy.</p>
                        <a href="<?php echo e(route('oferta')); ?>" class="text-emerald-600 font-semibold hover:text-emerald-700 inline-flex items-center gap-2 group">
                            Dowiedz się więcej
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                
                <div class="md:col-span-2 md:row-span-2 bento-card bg-slate-900 text-white relative overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="<?php echo e(asset('images/pexels-sliceisop-4737704.jpg')); ?>" alt="Klatki schodowe" class="w-full h-full object-cover opacity-40">
                    </div>
                    <div class="relative z-10 h-full flex flex-col justify-end p-8">
                        <span class="bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg w-fit mb-4">KLATKI</span>
                        <h3 class="font-display text-2xl font-bold mb-3">Klatki Schodowe i Wspólnoty</h3>
                        <p class="text-slate-300 mb-6 text-sm leading-relaxed">Regularnie, terminowo i z dbałością o szczegóły.</p>
                        <a href="<?php echo e(route('oferta')); ?>" class="text-emerald-400 font-semibold inline-flex items-center gap-2 group">
                            Dowiedz się więcej
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                
                <div class="md:col-span-2 bento-card bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-8 flex flex-col justify-center">
                    <h3 class="font-display text-xl font-bold mb-3">Gotowy na czystość?</h3>
                    <p class="text-emerald-100 text-sm mb-6 leading-relaxed">Zamów bezpłatną wycenę. Odpowiadamy w ciągu 2 godzin.</p>
                    <a href="<?php echo e(route('kontakt')); ?>" class="inline-flex items-center justify-center px-6 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-emerald-50 transition-all text-sm">
                        Zamów wycenę
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-padding bg-blue-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="<?php echo e(asset('images/pexels-ron-lach-10567353.jpg')); ?>" alt="" class="w-full h-full object-cover">
        </div>
        <div class="relative container-max mx-auto text-center" data-aos="zoom-in">
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white mb-6 tracking-tight">Gotowy na czystość bez kompromisów?</h2>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-10">
                Zamów bezpłatną wycenę i przekonaj się, jak możemy zadbać o czystość w Twojej firmie.
            </p>
            <a href="<?php echo e(route('kontakt')); ?>" class="btn-primary text-base px-10 py-4">
                Zamów darmową wycenę
            </a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/index.blade.php ENDPATH**/ ?>