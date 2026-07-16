<?php $__env->startSection('title', 'Zgłoszenia'); ?>
<?php $__env->startSection('header', 'Zgłoszenia usterek'); ?>

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
<div class="space-y-6">
    <div class="flex flex-wrap items-center gap-2">
        <a href="<?php echo e(route('admin.issue-reports.index')); ?>" class="rounded-full px-4 py-2 text-sm font-medium transition-colors <?php echo e(!$status ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50'); ?>">Wszystkie</a>
        <?php $__currentLoopData = ['pending', 'processing', 'resolved']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.issue-reports.index', ['status' => $s])); ?>" class="rounded-full px-4 py-2 text-sm font-medium transition-colors <?php echo e($status === $s ? ($s === 'pending' ? 'bg-rose-600 text-white' : ($s === 'processing' ? 'bg-amber-500 text-white' : 'bg-emerald-600 text-white')) : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50'); ?>">
                <?php echo e($statusLabels[$s]); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50"><tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Lokalizacja</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Opis</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Akcje</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($issue->isPending() ? 'bg-rose-50/40' : ''); ?> transition-colors hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-900"><?php echo e($issue->location->name ?? '—'); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e($issue->location?->typeLabel() ?? ''); ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700"><?php echo e($issue->description); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e($issue->reporter_name ?? 'Anonim'); ?> · <?php echo e($issue->created_at->translatedFormat('d.m.Y H:i')); ?></p>
                            <?php if($issue->photo_path): ?><a href="<?php echo e(asset('storage/' . $issue->photo_path)); ?>" target="_blank" class="text-xs font-medium text-emerald-600 hover:underline">Zdjęcie</a><?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($statusStyles[$issue->status]); ?>"><?php echo e($statusLabels[$issue->status]); ?></span>
                            <?php if($issue->assignee): ?><p class="mt-1 text-xs text-slate-400">Przyp. <?php echo e($issue->assignee->name); ?></p><?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('resolve', $issue)): ?>
                                    <button type="button" onclick="document.getElementById('resolve-<?php echo e($issue->id); ?>').classList.toggle('hidden')" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700">Rozwiąż</button>
                                <?php endif; ?>
                                <?php if(auth()->user()->isAdministrator()): ?>
                                    <button type="button" onclick="document.getElementById('manage-<?php echo e($issue->id); ?>').classList.toggle('hidden')" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-blue-50 hover:text-blue-600">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <?php if(auth()->user()->isAdministrator()): ?>
                                <form method="POST" action="<?php echo e(route('admin.issue-reports.update', $issue)); ?>" id="manage-<?php echo e($issue->id); ?>" class="hidden mt-3 flex items-center gap-2">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <select name="status" class="rounded-lg border-slate-300 px-2 py-1.5 text-xs">
                                        <option value="pending" <?php echo e($issue->isPending() ? 'selected' : ''); ?>>Oczekujące</option>
                                        <option value="processing" <?php echo e($issue->isProcessing() ? 'selected' : ''); ?>>W toku</option>
                                        <option value="resolved" <?php echo e($issue->isResolved() ? 'selected' : ''); ?>>Rozwiązane</option>
                                    </select>
                                    <select name="assigned_to" class="rounded-lg border-slate-300 px-2 py-1.5 text-xs">
                                        <option value="">— pracownik —</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($emp->id); ?>" <?php echo e($issue->assigned_to == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button class="rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white">OK</button>
                                </form>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('resolve', $issue)): ?>
                                <form method="POST" action="<?php echo e(route('admin.issue-reports.resolve', $issue)); ?>" id="resolve-<?php echo e($issue->id); ?>" class="hidden mt-3 space-y-2" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <input type="file" name="resolution_photo" accept="image/*" capture="environment" required class="w-full text-xs text-slate-500 file:mr-2 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-emerald-700">
                                    <button class="w-full rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white">Rozwiąż</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Brak zgłoszeń.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div><?php echo e($issues->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/issue-reports/index.blade.php ENDPATH**/ ?>