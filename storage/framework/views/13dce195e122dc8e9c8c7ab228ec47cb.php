<?php $__env->startSection('title', 'Moje zlecenia na dziś'); ?>
<?php $__env->startSection('header', 'Moje zlecenia na dziś'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-lg space-y-4">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <p class="text-sm text-slate-500">Data: <span class="font-semibold text-slate-900"><?php echo e(\Carbon\Carbon::parse($today)->translatedFormat('l, d.m.Y')); ?></span></p>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('admin.jobs.employee', $job)); ?>" class="block rounded-2xl border bg-white p-5 shadow-sm transition-all hover:shadow-md <?php echo e($job->isInProgress() ? 'border-amber-300 ring-2 ring-amber-100' : 'border-slate-200 hover:border-emerald-300'); ?>">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-display text-xl font-bold text-slate-900"><?php echo e(\Carbon\Carbon::parse($job->scheduled_time)->format('H:i')); ?></span>
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($job->statusColor()); ?>"><?php echo e($job->statusLabel()); ?></span>
                    </div>
                    <h3 class="font-display text-base font-bold text-slate-900"><?php echo e($job->location->name ?? '—'); ?></h3>
                    <?php if($job->location?->address): ?>
                        <p class="text-sm text-slate-500 mt-0.5"><?php echo e($job->location->address); ?></p>
                    <?php endif; ?>
                </div>
                <svg class="size-5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-slate-500">Nie masz zleceń na dziś. 🎉</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/jobs/employee-index.blade.php ENDPATH**/ ?>