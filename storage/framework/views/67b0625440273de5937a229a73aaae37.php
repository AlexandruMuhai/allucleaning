<?php $__env->startSection('title', 'Moje lokalizacje'); ?>
<?php $__env->startSection('header', 'Moje lokalizacje'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('admin.locations.show', $location)); ?>" class="block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-emerald-300 hover:shadow-md">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-display text-base font-bold text-slate-900"><?php echo e($location->name); ?></h3>
                    <?php if($location->address): ?><p class="text-sm text-slate-500 mt-0.5"><?php echo e($location->address); ?></p><?php endif; ?>
                    <p class="text-xs text-slate-400 mt-1"><?php echo e($location->typeLabel()); ?> · <?php echo e($location->passports_count); ?> stref QR</p>
                </div>
                <?php if($location->is_active): ?>
                    <span class="shrink-0 inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20"><span class="size-1.5 rounded-full bg-emerald-500"></span>Aktywna</span>
                <?php endif; ?>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-slate-500">Nie masz przypisanych lokalizacji.</p>
        </div>
    <?php endif; ?>
    <div><?php echo e($locations->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/locations/index-employee.blade.php ENDPATH**/ ?>