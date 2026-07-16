<?php
    $styles = [
        'administrator' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'pracownik' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
        'klient' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
    ];
    $style = $styles[$role->value] ?? 'bg-slate-100 text-slate-600 ring-slate-600/20';
?>
<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($style); ?>">
    <?php echo e($role->label()); ?>

</span>
<?php /**PATH /var/www/html/resources/views/admin/users/partials/role-badge.blade.php ENDPATH**/ ?>