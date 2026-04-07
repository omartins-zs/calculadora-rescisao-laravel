@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'helper' => null, 'model' => null])

<div class="space-y-1">
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}
    </label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        placeholder="{{ $placeholder }}"
        @if($model) x-model="{{ $model }}" @endif
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors']) }}
    >
    @if($helper)
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $helper }}</p>
    @endif
</div>
