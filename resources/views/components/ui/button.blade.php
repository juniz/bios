@props([
    'type' => 'button',
    'color' => 'primary',
    'size' => 'md',
    'label' => null,
    'icon' => null,
    'block' => false,
])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'btn btn-' .$color. ($block ? ' btn-block' : ''). ' btn-' .$size. '',
    ]) }}
>
    <div wire:loading.hide>
        @if($icon)
        <i class="{{ $icon }}"></i>
        @endif
        {{ $label ?? $slot }}
    </div>

    <div wire:loading>
        <i class="fas fa-spinner fa-spin"></i>
    </div>
</button>

