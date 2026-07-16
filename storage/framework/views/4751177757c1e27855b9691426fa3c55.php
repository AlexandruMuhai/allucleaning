<?php $__env->startSection('title', 'Zlecenia'); ?>
<?php $__env->startSection('header', 'Zlecenia sprzątania'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <form method="GET" class="flex flex-wrap items-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div>
            <label class="mb-1 block text-xs font-medium text-slate-500">Od</label>
            <input type="date" name="date_from" value="<?php echo e($dateFrom); ?>" class="rounded-xl border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>
        <div>
            <label class="mb-1 block text-xs font-medium text-slate-500">Do</label>
            <input type="date" name="date_to" value="<?php echo e($dateTo); ?>" class="rounded-xl border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>
        <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filtruj</button>
    </form>

    
    <?php $grouped = $jobs->groupBy(fn ($j) => $j->scheduled_date->translatedFormat('l, d.m.Y')); ?>

    <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayLabel => $dayJobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-3 bg-slate-50">
                <h3 class="font-display text-sm font-bold text-slate-700"><?php echo e($dayLabel); ?></h3>
            </div>
            <div class="divide-y divide-slate-100">
                <?php $__currentLoopData = $dayJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 text-center">
                                <p class="font-display text-lg font-bold text-slate-900"><?php echo e(\Carbon\Carbon::parse($job->scheduled_time)->format('H:i')); ?></p>
                            </div>
                            <div>
                                <a href="<?php echo e(route('admin.jobs.show', $job)); ?>" class="text-sm font-semibold text-slate-900 hover:text-emerald-600"><?php echo e($job->location->name ?? '—'); ?></a>
                                <p class="text-xs text-slate-400"><?php echo e($job->location?->typeLabel()); ?> · <?php echo e($job->location?->address); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:ml-auto">
                            <span class="rounded-full px-2.5 py-1 text-xs font-medium <?php echo e($job->statusColor()); ?>"><?php echo e($job->statusLabel()); ?></span>
                            <form method="POST" action="<?php echo e(route('admin.jobs.reassign', $job)); ?>" class="flex items-center gap-2">
                                <?php echo csrf_field(); ?>
                                <select name="employee_id" onchange="this.form.submit()" class="rounded-lg border-slate-300 px-2 py-1.5 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($emp->id); ?>" <?php echo e($job->employee_id == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($jobs->isEmpty()): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-slate-500">Brak zleceń w podanym okresie.</p>
        </div>
    <?php endif; ?>

    <div><?php echo e($jobs->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/jobs/index.blade.php ENDPATH**/ ?>