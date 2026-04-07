<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 sm:p-8 overflow-hidden']) }}>
    @if(isset($header))
        <div class="mb-6">
            {{ $header }}
        </div>
    @endif
    
    {{ $slot }}
</div>
