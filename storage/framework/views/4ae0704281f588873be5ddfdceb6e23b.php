<?php $__env->startSection('title', 'Obiekty'); ?>
<?php $__env->startSection('header', 'Lokalizacje'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">Łącznie: <span class="font-semibold text-slate-700"><?php echo e($locations->total()); ?></span></p>
        <?php if(auth()->user()->isAdministrator()): ?>
        <a href="<?php echo e(route('admin.locations.create')); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 active:scale-[0.98]">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Dodaj lokalizację
        </a>
        <?php endif; ?>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nazwa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Typ</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Klient</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Paszporty QR</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="transition-colors hover:bg-slate-50 <?php echo e(!$location->is_active ? 'opacity-60' : ''); ?>">
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('admin.locations.show', $location)); ?>" class="text-sm font-semibold text-slate-900 hover:text-emerald-600"><?php echo e($location->name); ?></a>
                            <?php if($location->address): ?><p class="text-xs text-slate-400 mt-0.5"><?php echo e($location->address); ?></p><?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($location->type === 'office' ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20' : 'bg-violet-50 text-violet-700 ring-1 ring-inset ring-violet-600/20'); ?>">
                                <?php echo e($location->typeLabel()); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600"><?php echo e($location->client?->name ?? '—'); ?></td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-700"><?php echo e($location->passports_count); ?></td>
                        <td class="px-6 py-4">
                            <?php if($location->is_active): ?>
                                <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium"><span class="size-1.5 rounded-full bg-emerald-500"></span>Aktywna</span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium"><span class="size-1.5 rounded-full bg-slate-300"></span>Nieaktywna</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.locations.show', $location)); ?>" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-emerald-50 hover:text-emerald-600" title="Szczegóły">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <?php if(auth()->user()->isAdministrator()): ?>
                                <a href="<?php echo e(route('admin.locations.edit', $location)); ?>" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-blue-50 hover:text-blue-600" title="Edytuj">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.locations.destroy', $location)); ?>" onsubmit="return confirm('Usunąć obiekt?');">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-rose-50 hover:text-rose-600" title="Usuń">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">Brak lokalizacji.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div><?php echo e($locations->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/locations/index.blade.php ENDPATH**/ ?>