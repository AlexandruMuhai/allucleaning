<?php $__env->startSection('title', $passport->zone_name); ?>
<?php $__env->startSection('header', $passport->zone_name . ' — ' . ($passport->location?->name ?? '')); ?>

<?php
    $statusStyles = [
        'pending' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'processing' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'resolved' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
    ];
    $statusLabels = [
        'pending' => 'Oczekujące',
        'processing' => 'W toku',
        'resolved' => 'Rozwiązane',
    ];
?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-1">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm">
            <p class="mb-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Kod QR</p>
            <div class="mx-auto my-4 flex size-56 items-center justify-center rounded-2xl bg-white p-2 ring-1 ring-slate-100"><?php echo $qrSvg; ?></div>
            <a href="<?php echo e(route('passport.show', $passport->uuid)); ?>" target="_blank" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Podgląd publiczny ↗</a>
            <div class="mt-4 rounded-xl bg-slate-50 p-3 text-left text-xs text-slate-500 space-y-1">
                <p>Strefa: <span class="font-medium text-slate-700"><?php echo e($passport->zone_name); ?></span></p>
                <p>Lokalizacja: <span class="font-medium text-slate-700"><?php echo e($passport->location?->name ?? '—'); ?></span></p>
                <p>UUID: <span class="font-mono text-slate-400"><?php echo e(substr($passport->uuid, 0, 16)); ?>…</span></p>
                <p>Nast. sprzątanie: <span class="font-medium text-slate-700"><?php echo e($passport->next_scheduled_clean?->translatedFormat('d.m.Y H:i') ?? '—'); ?></span></p>
            </div>
        </div>
    </div>
    <div class="space-y-6 lg:col-span-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h2 class="font-display text-base font-bold text-slate-900">Ostatnie sprzątania</h2>
                <a href="<?php echo e(route('admin.clean-logs.create')); ?>" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">+ Dodaj</a>
            </div>
            <div class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $passport->cleanLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center gap-3 px-6 py-3">
                        <?php if($log->photo_path): ?>
                            <img src="<?php echo e(asset('storage/' . $log->photo_path)); ?>" class="size-12 rounded-lg object-cover">
                        <?php else: ?>
                            <div class="flex size-12 items-center justify-center rounded-lg bg-slate-100 text-slate-400"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <?php endif; ?>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-900"><?php echo e($log->cleaned_at->translatedFormat('d.m.Y H:i')); ?> · <?php echo e($log->user->name ?? 'Pracownik'); ?></p>
                            <?php if($log->notes): ?><p class="truncate text-xs text-slate-500"><?php echo e($log->notes); ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="px-6 py-6 text-center text-sm text-slate-500">Brak wpisów.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4"><h2 class="font-display text-base font-bold text-slate-900">Zgłoszone uwagi</h2></div>
            <div class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $passport->issueReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900"><?php echo e($issue->description); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($issue->reporter_name ?? 'Anonim'); ?> · <?php echo e($issue->created_at->translatedFormat('d.m.Y H:i')); ?></p>
                            </div>
                            <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($statusStyles[$issue->status]); ?>"><?php echo e($statusLabels[$issue->status]); ?></span>
                        </div>
                        <?php if($issue->photo_path): ?><img src="<?php echo e(asset('storage/' . $issue->photo_path)); ?>" class="mt-3 max-h-40 rounded-lg object-cover"><?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="px-6 py-6 text-center text-sm text-slate-500">Brak zgłoszeń.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/passports/show.blade.php ENDPATH**/ ?>