@props([
    'type' => 'success',
    'message' => null,
    'duration' => 4000
])

@php
    if (!$message) return;

    $config = [
        'success' => [
            'border' => 'border-green-500',
            'bg'     => 'bg-green-50',
            'text'   => 'text-green-500',
            'title'  => 'Success!',
            'icon'   => "
                <svg class='fill-current' width='24' height='24' viewBox='0 0 24 24'>
                    <path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'/>
                </svg>
            ",
        ],
        'error' => [
            'border' => 'border-red-500',
            'bg'     => 'bg-red-50',
            'text'   => 'text-red-500',
            'title'  => 'Error!',
            'icon'   => "
            <svg class='fill-current text-red-500' width='24' height='24' viewBox='0 0 24 24'>
                <path fill-rule='evenodd' clip-rule='evenodd' d='M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z' fill='currentColor'/>
            </svg>
        ",
        ],
        'warning' => [
            'border' => 'border-orange-500',
            'bg'     => 'bg-orange-50',
            'text'   => 'text-orange-500',
            'title'  => 'Warning!',
            'icon'   => "
            <svg class='fill-current text-orange-500' width='24' height='24' viewBox='0 0 24 24'>
                <path fill-rule='evenodd' clip-rule='evenodd' d='M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z' fill='currentColor'/>
            </svg>
        ",
        ],
    ];

    if (!isset($config[$type])) return;

    $id = uniqid('toast_');
    $c = $config[$type];
@endphp

<div id="{{ $id }}" class="fixed top-21 right-4 z-10000 transform translate-x-[150%] transition-all duration-500 ease-in-out md:right-6 md:w-full md:max-w-sm">
    <div class="rounded-xl border {{ $c['border'] }} {{ $c['bg'] }} p-4 shadow-2xl">
        <div class="flex items-start gap-3">
            <div class="shrink-0 {{ $c['text'] }}">
                {!! $c['icon'] !!}
            </div>
            <div class="min-w-0">
                <h4 class="mb-1 text-sm font-semibold text-gray-800">{{ $c['title'] }}</h4>
                <p class="text-sm text-gray-500">{{ $message }}</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('{{ $id }}');
        if (!toast) return;

        setTimeout(() => {
            toast.classList.remove('translate-x-[150%]');
            toast.classList.add('translate-x-0');
        }, 100);

        setTimeout(() => {
            toast.classList.add('translate-x-[150%]');
            toast.classList.remove('translate-x-0');
            
            setTimeout(() => toast.remove(), 500);
        }, {{ $duration }});
    });
</script>