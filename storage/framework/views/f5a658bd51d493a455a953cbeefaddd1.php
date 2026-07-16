<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie — <?php echo e(config('app.name')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Urbanist:wght@500;600;700;800&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="h-full bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="flex min-h-full flex-col lg:flex-row">

        
        <div class="relative flex w-full flex-col justify-center px-6 py-12 lg:w-1/2">
            <a href="<?php echo e(route('home')); ?>" class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Wróć do strony głównej
            </a>

            <div class="mx-auto w-full max-w-md text-center">
                <a href="<?php echo e(route('home')); ?>" class="mb-8 inline-block">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Alluc Cleaning" class="mx-auto h-14 w-auto">
                </a>

                <div class="mt-8">
                    <form method="POST" action="<?php echo e(route('admin.login.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-5 text-left">
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Adres email</label>
                            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                                   class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1.5 text-sm text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-5 text-left">
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Hasło</label>
                            <input id="password" type="password" name="password" required
                                   class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div class="mb-6 flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                Zapamiętaj mnie
                            </label>
                            <a href="<?php echo e(route('admin.password.request')); ?>" class="text-sm font-medium text-emerald-600 transition-colors hover:text-emerald-700">
                                Zapomniałeś hasła?
                            </a>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 hover:shadow-emerald-500/30 active:scale-[0.98]">
                            Zaloguj się
                        </button>
                    </form>
                </div>

                <p class="mt-8 text-xs text-slate-400">
                    &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. Wszelkie prawa zastrzeżone.
                </p>
            </div>
        </div>

        
        <div class="relative hidden w-full items-center justify-center overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-cyan-700 px-10 py-16 lg:flex lg:w-1/2">
            <div class="absolute -right-16 -top-16 size-72 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-20 -left-10 size-80 rounded-full bg-cyan-400/20 blur-3xl"></div>

            <div class="relative max-w-lg">
                <h2 class="font-display text-4xl font-extrabold leading-[1.1] text-white">
                    Zarządzaj czystością w czasie rzeczywistym.
                </h2>

                <div class="my-6 h-px w-16 bg-emerald-400/70"></div>

                <p class="text-base leading-relaxed text-blue-100/90">
                    Nowy standard obsługi Twojej nieruchomości. Oddajemy w Twoje ręce system,
                    który eliminuje chaos komunikacyjny i daje Ci <span class="font-semibold text-white">100% kontroli</span>
                    bez konieczności osobistego sprawdzania każdego kąta.
                </p>

                <ul class="mt-8 space-y-4">
                    <li class="flex gap-3.5">
                        <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/20">
                            <svg class="size-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M1.5 12s4-7 10.5-7C18.5 5 22.5 12 22.5 12s-4 7-10.5 7C5.5 19 1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">Wgląd w realizację 24/7</p>
                            <p class="mt-0.5 text-sm text-blue-100/80">Harmonogramy, statusy prac i fotograficzne potwierdzenia wykonania usługi w jednym, przejrzystym miejscu.</p>
                        </div>
                    </li>
                    <li class="flex gap-3.5">
                        <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/20">
                            <svg class="size-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">Transparentne rozliczenia</p>
                            <p class="mt-0.5 text-sm text-blue-100/80">Automatyczne faktury uwzględniające faktycznie zrealizowane usługi oraz wykorzystane materiały eksploatacyjne.</p>
                        </div>
                    </li>
                    <li class="flex gap-3.5">
                        <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/20">
                            <svg class="size-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">Szybkie zaopatrzenie biura</p>
                            <p class="mt-0.5 text-sm text-blue-100/80">Zapomnij o pamiętaniu o chemii i artykułach higienicznych. System sam podpowie Ci, kiedy zamówić dostawę.</p>
                        </div>
                    </li>
                    <li class="flex gap-3.5">
                        <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/20">
                            <svg class="size-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5h18M3 12h18M3 19h18"/></svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">Obsługa ticketów QR</p>
                            <p class="mt-0.5 text-sm text-blue-100/80">Reaguj na potrzeby swoich ludzi, zanim staną się problemem. System zgłoszeń automatycznie informuje nasz zespół o nagłych zdarzeniach.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>