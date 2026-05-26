@props(['label', 'value', 'color' => 'brand', 'description' => null])

@php
$bg = [
    'brand' => 'bg-emerald-50 dark:bg-emerald-950/20',
    'indigo' => 'bg-indigo-50 dark:bg-indigo-950/20',
    'red' => 'bg-red-50 dark:bg-red-950/20',
][$color] ?? 'bg-slate-50 dark:bg-slate-800';

$text = [
    'brand' => 'text-emerald-700 dark:text-emerald-400',
    'indigo' => 'text-indigo-700 dark:text-indigo-400',
    'red' => 'text-red-700 dark:text-red-400',
][$color] ?? 'text-slate-800 dark:text-slate-200';

$border = [
    'brand' => 'border-emerald-100 dark:border-emerald-900/30',
    'indigo' => 'border-indigo-100 dark:border-indigo-900/30',
    'red' => 'border-red-100 dark:border-red-900/30',
][$color] ?? 'border-slate-200 dark:border-slate-700';
@endphp

<div class="{{ $bg }} {{ $border }} rounded-xl p-4 border hover:shadow-md transition-shadow">
    <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">{{ $label }}</h3>
    <div class="text-2xl font-bold font-mono {{ $text }}" :class="{ 'opacity-50': isLoading }">
        <span x-text="{{ $value }}"></span>
    </div>
    @if($description)
        <p class="text-xs text-slate-400 mt-2">{{ $description }}</p>
    @endif
</div>
