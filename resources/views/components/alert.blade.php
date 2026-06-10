@props([
    'type' => 'success',   // 'success' | 'error'
    'message' => null,
])

@php
    $config = match($type) {
        'error'   => [
            'wrapper' => 'bg-red-50 border-red-200 text-red-800',
            'icon'    => 'text-red-500',
            'path'    => 'M6 18L18 6M6 6l12 12',
        ],
        default   => [
            'wrapper' => 'bg-green-50 border-green-200 text-green-800',
            'icon'    => 'text-green-500',
            'path'    => 'M5 13l4 4L19 7',
        ],
    };

    $sessionKey = $type === 'error' ? 'error' : 'success';
    $text = $message ?? session($sessionKey);
@endphp

@if($text)
    <div class="flex items-center gap-3 border {{ $config['wrapper'] }} text-sm rounded-lg px-4 py-3 mb-6" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5 {{ $config['icon'] }} flex-shrink-0"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['path'] }}" />
        </svg>
        <span>{{ $text }}</span>
    </div>
@endif
