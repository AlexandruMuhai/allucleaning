<?php $__env->startSection('title', 'Nowa lokalizacja'); ?>
<?php $__env->startSection('header', 'Nowa lokalizacja'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-display text-base font-bold text-slate-900">Dane lokalizacji</h2>
        </div>
        <form method="POST" action="<?php echo e(route('admin.locations.store')); ?>" class="space-y-5 p-6">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nazwa</label>
                    <input id="name" name="name" value="<?php echo e(old('name')); ?>" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. Biuro Startup Sp. z o.o.">
                </div>
                <div>
                    <label for="type" class="mb-2 block text-sm font-medium text-slate-700">Typ</label>
                    <select id="type" name="type" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="office" <?php echo e(old('type') === 'office' ? 'selected' : ''); ?>>Biuro</option>
                        <option value="staircase" <?php echo e(old('type') === 'staircase' ? 'selected' : ''); ?>>Klatka schodowa</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="address" class="mb-2 block text-sm font-medium text-slate-700">Adres</label>
                <input id="address" name="address" value="<?php echo e(old('address')); ?>" required class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label for="client_id" class="mb-2 block text-sm font-medium text-slate-700">Właściciel / Klient</label>
                <select id="client_id" name="client_id" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">— brak —</option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>><?php echo e($client->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="area_sqm" class="mb-2 block text-sm font-medium text-slate-700">Metraż (m²)</label>
                    <input id="area_sqm" type="number" name="area_sqm" value="<?php echo e(old('area_sqm')); ?>" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label for="schedule_info" class="mb-2 block text-sm font-medium text-slate-700">Harmonogram</label>
                    <input id="schedule_info" name="schedule_info" value="<?php echo e(old('schedule_info')); ?>" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. Wtorki i Czwartki od 18:00">
                </div>
            </div>
            <div>
                <label for="access_code" class="mb-2 block text-sm font-medium text-slate-700">Kod dostępu</label>
                <input id="access_code" name="access_code" value="<?php echo e(old('access_code')); ?>" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Kod do domofonu, sejfu...">
            </div>
            <div>
                <label for="cleaning_instructions" class="mb-2 block text-sm font-medium text-slate-700">Instrukcje sprzątania</label>
                <textarea id="cleaning_instructions" name="cleaning_instructions" rows="4" class="w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="np. nie myć biurka prezesa, używać zielonej ściereczki do kurzu"><?php echo e(old('cleaning_instructions')); ?></textarea>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Przypisani pracownicy</label>
                <div class="space-y-2 rounded-xl border border-slate-200 p-4 max-h-40 overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="employees[]" value="<?php echo e($emp->id); ?>" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <?php echo e($emp->name); ?>

                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-xs text-slate-400">Brak pracowników w systemie.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="<?php echo e(route('admin.locations.index')); ?>" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100">Anuluj</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">Zapisz</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/locations/create.blade.php ENDPATH**/ ?>