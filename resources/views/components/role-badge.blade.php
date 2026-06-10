@props(['role'])

@php
    $classes = match($role->name ?? $role) {
        'Admin'   => 'bg-purple-100 text-purple-700',
        'Manager' => 'bg-blue-100 text-blue-700',
        default   => 'bg-gray-100 text-gray-600',
    };
    $label = $role->name ?? $role;
@endphp

<span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $classes }}">
    {{ $label }}
</span>
