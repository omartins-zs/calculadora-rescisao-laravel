@props(['label', 'title', 'value', 'color' => 'brand'])

<div class="bg-{{ $color }}-50 dark:bg-slate-800/50 rounded-xl p-4 border border-{{ $color }}-100 dark:border-slate-700 hover:shadow-md transition-shadow">
    <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">{{ $label }}</h3>
    <div class="text-2xl font-bold font-mono text-{{ $color }}-700 dark:text-{{ $color }}-400" :class="{ 'opacity-50': isLoading }">
        <span x-text="{{ $value }}"></span>
    </div>
    @if(isset($description))
        <p class="text-xs text-slate-400 mt-2">{{ $description }}</p>
    @endif
</div>
