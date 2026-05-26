@props([
    'label',
    'name',
    'type'        => 'text',
    'placeholder' => '',
    'helper'      => null,
    'model'       => null,
    'icon'        => null,
])

<div class="space-y-1.5">

    {{-- Label normal acima do campo --}}
    <label for="{{ $name }}"
           class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}
    </label>

    <div class="relative">

        {{-- Ícone à esquerda --}}
        @if($icon === 'currency')
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">R$</span>
            </div>
        @elseif($icon === 'calendar')
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @elseif($icon === 'number')
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                </svg>
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @if($model) x-model="{{ $model }}" @endif
            {{ $attributes->merge([
                'class' => implode(' ', array_filter([
                    'block w-full rounded-xl border text-sm',
                    'bg-white dark:bg-slate-800/70',
                    'text-slate-900 dark:text-slate-100',
                    'border-slate-300 dark:border-slate-600',
                    'placeholder-slate-400 dark:placeholder-slate-500',
                    'py-2.5 px-3',
                    $icon ? 'pl-9' : '',
                    'focus:outline-none focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500',
                    'dark:focus:border-brand-400 dark:focus:ring-brand-400/30',
                    'transition-all duration-200 shadow-sm',
                    $type === 'date' ? 'cursor-pointer' : '',
                ]))
            ]) }}
        >
    </div>

    @if($helper)
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $helper }}</p>
    @endif
</div>
