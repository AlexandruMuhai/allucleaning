<?php $__env->startSection('title', 'Oznacz sprzątanie'); ?>
<?php $__env->startSection('header', 'Oznacz sprzątanie'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4"><h2 class="font-display text-base font-bold text-slate-900">Sprzątanie wykonane</h2></div>
        <form method="POST" action="<?php echo e(route('admin.clean-logs.store')); ?>" enctype="multipart/form-data" class="space-y-5 p-6">
            <?php echo csrf_field(); ?>
            <div>
                <label for="qr_passport_id" class="mb-2 block text-sm font-medium text-slate-700">Strefa / Kod QR</label>
                <select id="qr_passport_id" name="qr_passport_id" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 <?php $__errorArgs = ['qr_passport_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Wybierz strefę…</option>
                    <?php $__currentLoopData = $passports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $passport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($passport->id); ?>"><?php echo e($passport->zone_name); ?> <?php if($passport->location): ?> (<?php echo e($passport->location->name); ?>) <?php endif; ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['qr_passport_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-rose-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="notes" class="mb-2 block text-sm font-medium text-slate-700">Notatka (opcjonalnie)</label>
                <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. uzupełniono mydło"></textarea>
            </div>
            <div>
                <label for="photo" class="mb-2 block text-sm font-medium text-slate-700">Zdjęcie poświadczające (opcjonalnie)</label>
                <input id="photo" type="file" name="photo" accept="image/*" capture="environment" class="w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">Oznacz jako wykonane</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/clean-logs/create.blade.php ENDPATH**/ ?>