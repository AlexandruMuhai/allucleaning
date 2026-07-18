<?php $__env->startSection('title', 'Grafik'); ?>
<?php $__env->startSection('header', 'Grafik — Centrum Dowodzenia'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4" x-data="scheduleApp()">

    
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
            <span class="flex items-center gap-1.5"><span class="size-3 rounded-full bg-[#94a3b8]"></span> Zaplanowane</span>
            <span class="flex items-center gap-1.5"><span class="size-3 rounded-full bg-[#f59e0b]"></span> W toku</span>
            <span class="flex items-center gap-1.5"><span class="size-3 rounded-full bg-[#22c55e]"></span> Ukończone</span>
            <span class="flex items-center gap-1.5"><span class="size-3 rounded-full bg-[#ef4444]"></span> Alarm / Spóźnienie</span>
        </div>
        <div class="flex items-center gap-2">
            <button @click=" calendar?.prev(); " class="rounded-lg bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50">← Poprzedni</button>
            <button @click=" calendar?.today(); " class="rounded-lg bg-white px-3 py-1.5 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-200 hover:bg-emerald-50">Dziś</button>
            <button @click=" calendar?.next(); " class="rounded-lg bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50">Następny →</button>
            <select x-model="viewType" @change="changeView()" class="rounded-lg border-slate-300 px-3 py-1.5 text-sm font-semibold">
                <option value="resourceTimelineDay">Dzień</option>
                <option value="resourceTimelineWeek">Tydzień</option>
            </select>
        </div>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div id="calendar"></div>
    </div>

    
    <template x-if="conflictWarning">
        <div class="fixed bottom-6 right-6 z-50 max-w-sm rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-2xl" x-transition>
            <div class="flex items-start gap-3">
                <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-amber-100">
                    <svg class="size-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5 19h14a2 2 0 001.94-2.53l-7-12a2 2 0 00-3.48 0l-7 12A2 2 0 005 19z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-amber-800">Konflikt wykryty</p>
                    <p class="mt-1 text-xs text-amber-700" x-text="conflictWarning"></p>
                </div>
                <button @click="conflictWarning = null" class="shrink-0 text-amber-400 hover:text-amber-600">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </template>

    
    <template x-if="selectedJob">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" @click.self="selectedJob = null" x-transition.opacity>
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl" @click.stop>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-display text-lg font-bold text-slate-900" x-text="selectedJob.title"></h3>
                        <p class="text-sm text-slate-500" x-text="selectedJob.address"></p>
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="statusClass(selectedJob.status)" x-text="selectedJob.statusLabel"></span>
                </div>

                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Data</span><span class="font-medium text-slate-900" x-text="formatDate(selectedJob.start)"></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Godzina</span><span class="font-medium text-slate-900" x-text="formatTime(selectedJob.start) + ' – ' + formatTime(selectedJob.end)"></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Czas trwania</span><span class="font-medium text-slate-900" x-text="selectedJob.scheduledDuration + ' min'"></span></div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a :href="'/admin/jobs/' + selectedJob.jobId" class="flex-1 rounded-xl bg-emerald-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-emerald-500">Szczegóły zlecenia</a>
                    <button @click="selectedJob = null" class="rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-200">Zamknij</button>
                </div>
            </div>
        </div>
    </template>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function scheduleApp() {
    return {
        calendar: null,
        viewType: 'resourceTimelineDay',
        selectedJob: null,
        conflictWarning: null,

        init() {
            const calendarEl = document.getElementById('calendar');

            this.calendar = new window.FullCalendar.Calendar(calendarEl, {
                plugins: [window.FullCalendar.resourceTimelinePlugin],
                initialView: 'resourceTimelineDay',
                locale: window.FullCalendar.plLocale,
                firstDay: 1,
                slotMinTime: '06:00:00',
                slotMaxTime: '22:00:00',
                slotDuration: '00:15:00',
                slotLabelInterval: '01:00:00',
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                },
                height: 'auto',
                expandRows: true,
                nowIndicator: true,
                allDaySlot: false,

                headerToolbar: false,
                resourceAreaHeaderContent: 'Pracownicy',
                resourceAreaWidth: '180px',
                resourceLabelClassNames: 'font-semibold text-sm',

                editable: true,
                eventStartEditable: true,
                eventDurationEditable: true,

                resourceOrder: 'title',

                resources: '<?php echo e(route("admin.schedule.resources")); ?>',

                events: {
                    url: '<?php echo e(route("admin.schedule.events")); ?>',
                    extraParams: () => ({
                        start: this.calendar?.view?.activeStart?.toISOString()?.split('T')[0] || '',
                        end: this.calendar?.view?.activeEnd?.toISOString()?.split('T')[0] || '',
                    }),
                },

                eventContent: function(arg) {
                    const status = arg.event.extendedProps.status;
                    const location = arg.event.title;
                    const start = new Date(arg.event.start).toLocaleTimeString('pl-PL', {hour: '2-digit', minute: '2-digit'});

                    return {
                        html: `<div class="fc-event-content-inner p-1 cursor-pointer">
                            <div class="text-[10px] font-bold leading-tight truncate">${start}</div>
                            <div class="text-[10px] leading-tight truncate opacity-80">${location}</div>
                        </div>`,
                    };
                },

                eventClick: (info) => {
                    const props = info.event.extendedProps;
                    this.selectedJob = {
                        jobId: props.jobId,
                        title: info.event.title,
                        address: props.address,
                        status: props.status,
                        statusLabel: props.statusLabel,
                        start: info.event.start,
                        end: info.event.end,
                        scheduledDuration: props.scheduledDuration,
                    };
                },

                eventDrop: async (info) => {
                    const jobId = info.event.id;
                    const newEmployeeId = info.event.getResources()[0]?.id;
                    const newStart = info.event.start;
                    const newEnd = info.event.end;

                    // Check conflicts first
                    const conflicts = await this.checkConflicts(newEmployeeId, newStart.toISOString(), newEnd.toISOString(), jobId, info.event.extendedProps.locationId);

                    if (conflicts.has_conflicts) {
                        let msg = '';
                        if (conflicts.conflicts?.length) {
                            msg += 'Konflikt czasowy: pracownik ma już zlecenie w tym terminie. ';
                        }
                        if (conflicts.travel_warning) {
                            msg += conflicts.travel_warning.message;
                        }
                        this.conflictWarning = msg;
                    }

                    // Update time
                    try {
                        const response = await fetch(`/admin/schedule/${jobId}/time`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                start: newStart.toISOString(),
                                end: newEnd.toISOString(),
                            }),
                        });

                        if (response.ok) {
                            this.calendar.refetchEvents();
                        }
                    } catch (e) {
                        info.revert();
                    }

                    // Reassign employee
                    const oldEmployeeId = String(info.event.extendedProps.employeeId);
                    if (newEmployeeId && newEmployeeId !== oldEmployeeId) {
                        try {
                            await fetch(`/admin/schedule/${jobId}/reassign`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({ employee_id: parseInt(newEmployeeId) }),
                            });
                            this.calendar.refetchEvents();
                        } catch (e) {
                            info.revert();
                        }
                    }
                },

                eventResize: async (info) => {
                    const jobId = info.event.id;
                    try {
                        const response = await fetch(`/admin/schedule/${jobId}/time`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                start: info.event.start.toISOString(),
                                end: info.event.end.toISOString(),
                            }),
                        });

                        if (response.ok) {
                            this.calendar.refetchEvents();
                        }
                    } catch (e) {
                        info.revert();
                    }
                },

                async checkConflicts(employeeId, start, end, excludeJobId, locationId) {
                    try {
                        const response = await fetch('<?php echo e(route("admin.schedule.conflicts")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                employee_id: employeeId,
                                start: start,
                                end: end,
                                exclude_job_id: excludeJobId,
                                location_id: locationId,
                            }),
                        });
                        return await response.json();
                    } catch (e) {
                        return { has_conflicts: false, conflicts: [], travel_warning: null };
                    }
                },

                changeView() {
                    this.calendar?.changeView(this.viewType);
                },

                statusClass(status) {
                    return {
                        'pending': 'bg-slate-100 text-slate-700',
                        'in_progress': 'bg-amber-50 text-amber-700',
                        'completed': 'bg-emerald-50 text-emerald-700',
                        'cancelled': 'bg-rose-50 text-rose-600',
                    }[status] || 'bg-slate-100 text-slate-700';
                },

                formatDate(date) {
                    return new Date(date).toLocaleDateString('pl-PL', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                },

                formatTime(date) {
                    return new Date(date).toLocaleTimeString('pl-PL', { hour: '2-digit', minute: '2-digit' });
                },
            });

            this.calendar.render();
        },
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/schedule/index.blade.php ENDPATH**/ ?>