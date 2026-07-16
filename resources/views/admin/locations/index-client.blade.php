@extends('admin.layout')
@section('title', 'Moje lokalizacje')
@section('header', 'Moje lokalizacje')

@section('content')
<div class="space-y-4">
    @forelse ($locations as $location)
        <a href="{{ route('admin.locations.show', $location) }}" class="block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-emerald-300 hover:shadow-md">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-display text-base font-bold text-slate-900">{{ $location->name }}</h3>
                    @if ($location->address)<p class="text-sm text-slate-500 mt-0.5">{{ $location->address }}</p>@endif
                    <p class="text-xs text-slate-400 mt-1">{{ $location->typeLabel() }}</p>
                </div>
                <span class="shrink-0 rounded-xl bg-slate-50 px-3 py-1 text-xs font-medium text-slate-500">{{ $location->passports_count }} QR</span>
            </div>
        </a>
    @empty
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm text-slate-500">Nie masz przypisanych lokalizacji.</p>
        </div>
    @endforelse
    <div>{{ $locations->links() }}</div>
</div>
@endsection
