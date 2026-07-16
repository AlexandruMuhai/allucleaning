@extends('admin.layout')
@section('title', 'Zlecenia')
@section('header', 'Zlecenia sprzątania')

@section('content')
<div class="space-y-6">
    {{-- Filtr dat --}}
    <form method="GET" class="flex flex-wrap items-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div>
            <label class="mb-1 block text-xs font-medium text-slate-500">Od</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-xl border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>
        <div>
            <label class="mb-1 block text-xs font-medium text-slate-500">Do</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-xl border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>
        <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filtruj</button>
    </form>

    {{-- Grupowanie po dniach --}}
    @php $grouped = $jobs->groupBy(fn ($j) => $j->scheduled_date->translatedFormat('l, d.m.Y')); @endphp

    @foreach ($grouped as $dayLabel => $dayJobs)
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-3 bg-slate-50">
                <h3 class="font-display text-sm font-bold text-slate-700">{{ $dayLabel }}</h3>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach ($dayJobs as $job)
                    <div class="flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 text-center">
                                <p class="font-display text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($job->scheduled_time)->format('H:i') }}</p>
                            </div>
                            <div>
                                <a href="{{ route('admin.jobs.show', $job) }}" class="text-sm font-semibold text-slate-900 hover:text-emerald-600">{{ $job->location->name ?? '—' }}</a>
                                <p class="text-xs text-slate-400">{{ $job->location?->typeLabel() }} · {{ $job->location?->address }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:ml-auto">
                            <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $job->statusColor() }}">{{ $job->statusLabel() }}</span>
                            <form method="POST" action="{{ route('admin.jobs.reassign', $job) }}" class="flex items-center gap-2">
                                @csrf
                                <select name="employee_id" onchange="this.form.submit()" class="rounded-lg border-slate-300 px-2 py-1.5 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ $job->employee_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    @if ($jobs->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-slate-500">Brak zleceń w podanym okresie.</p>
        </div>
    @endif

    <div>{{ $jobs->links() }}</div>
</div>
@endsection
