@props([
    'label' => null,
    'id' => null,
    'type' => 'text',
    'model' => null,
    'placeholder' => '',
])

<div class="form-group row">
    @if ($label)
        <label for="{{ $id }}" class="col-sm-3 col-form-label">{{ $label }}</label>
    @endif

    <div class="col-sm-9">
        <input
            id="{{ $id }}"
            name="{{ $id }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'form-control']) }}
            @if ($model)
                wire:model.defer="{{ $model }}"
            @endif
        />

        @error($id)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>