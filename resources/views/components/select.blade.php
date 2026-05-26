@props(['label', 'name', 'options' => [], 'helper' => null, 'model' => null])

<div class="space-y-1.5">

    {{-- Label normal acima --}}
    <label for="{{ $name }}"
           class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}
    </label>

    <div class="relative">
        {{-- Ícone de chevron customizado --}}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <select
            name="{{ $name }}"
            id="{{ $name }}"
            @if($model) x-model="{{ $model }}" @endif
            {{ $attributes->merge([
                'class' => 'block w-full rounded-xl border text-sm
                            bg-white dark:bg-slate-800/70
                            text-slate-900 dark:text-slate-100
                            border-slate-300 dark:border-slate-600
                            py-2.5 px-3 pr-9
                            appearance-none
                            focus:outline-none focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500
                            dark:focus:border-brand-400 dark:focus:ring-brand-400/30
                            transition-all duration-200 shadow-sm cursor-pointer'
            ]) }}
        >
            @foreach($options as $value => $text)
                <option value="{{ $value }}">{{ $text }}</option>
            @endforeach
        </select>
    </div>

    @if($helper)
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $helper }}</p>
    @endif
</div>
