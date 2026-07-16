<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset hasła — <?php echo e(config('app.name')); ?></title>
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
                <div class="mt-8">
                    <form method="POST" action="<?php echo e(route('admin.password.email')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-6">
                            <h1 class="font-display text-2xl font-bold text-slate-900">Reset hasła</h1>
                            <p class="mt-2 text-sm text-slate-500">Podaj adres email powiązany z kontem, a wyślemy link do zresetowania hasła.</p>
                        </div>

                        <?php if(session('status')): ?>
                            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

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

                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 hover:shadow-emerald-500/30 active:scale-[0.98]">
                            Wyślij link do resetu
                        </button>

                        <a href="<?php echo e(route('admin.login')); ?>" class="mt-5 inline-block text-sm font-medium text-emerald-600 transition-colors hover:text-emerald-700">
                            Wróć do logowania
                        </a>
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

            <div class="relative max-w-md">
                <div class="mb-8 flex items-center gap-3">
                    <div class="flex size-11 items-center justify-center rounded-2xl bg-white/15 font-display text-xl font-extrabold text-white ring-1 ring-white/20">
                        A
                    </div>
                    <span class="font-display text-2xl font-bold tracking-tight text-white">Alluc Cleaning</span>
                </div>

                <h2 class="font-display text-4xl font-extrabold leading-tight text-white">
                    Monitoruj czystość swojego biznesu w czasie rzeczywistym
                </h2>

                <div class="my-6 h-px w-16 bg-emerald-400/70"></div>

                <p class="text-base leading-relaxed text-blue-100/90">
                    To centrum dowodzenia Twoimi usługami sprzątającymi. Zarządzaj zleceniami,
                    sprawdzaj raporty z realizacji, przypisuj zadania pracownikom i dbaj o to,
                    by każda powierzchnia lśniła. Czystość pod kontrolą — od biura po wspólnotę mieszkaniową.
                </p>

                <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <div class="border-l-2 border-white/20 pl-4">
                        <p class="text-sm font-semibold text-white">Aktywne zlecenia</p>
                        <p class="mt-0.5 text-xs text-blue-100/80">Przegląd terminów i realizacji</p>
                    </div>
                    <div class="border-l-2 border-white/20 pl-4">
                        <p class="text-sm font-semibold text-white">Pracownicy i klienci</p>
                        <p class="mt-0.5 text-xs text-blue-100/80">Zarządzanie dostępem i rolami</p>
                    </div>
                    <div class="border-l-2 border-white/20 pl-4">
                        <p class="text-sm font-semibold text-white">Gwarancja 24h</p>
                        <p class="mt-0.5 text-xs text-blue-100/80">Kontrola jakości usług</p>
                    </div>
                    <div class="border-l-2 border-white/20 pl-4">
                        <p class="text-sm font-semibold text-white">Raporty</p>
                        <p class="mt-0.5 text-xs text-blue-100/80">Analiza czystości w czasie</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/admin/auth/forgot-password.blade.php ENDPATH**/ ?>