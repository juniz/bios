@props([
    'label' => null,
    'id' => null,
    'model' => null,
    'placeholder' => '',
])

<div class="form-group">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $id }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-control']) }}
        @if ($model)
            wire:model.defer="{{ $model }}"
        @endif
        @if($attributes->has('multiple'))
            multiple
        @endif
    >
        {{ $slot }}
    </select>

    @error($id)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

@push('js')
    <script>
        $(function () {
            $('#{{ $id }}').select2({
                theme: 'bootstrap4',
                placeholder: "{{ $placeholder }}",
                allowClear: true,
            });

            $('#{{ $id }}').on('change', function (e) {
                if(!e.target.value){
                    @this.set('{{ $model }}', '');
                }else{
                    @this.set('{{ $model }}', e.target.value);
                }
            });

            Livewire.hook('message.processed', (message, component) => {
                $('#{{ $id }}').select2({
                    theme: 'bootstrap4',
                    placeholder: "{{ $placeholder }}",
                    allowClear: true,
                });
            });
        });
    </script>
@endpush