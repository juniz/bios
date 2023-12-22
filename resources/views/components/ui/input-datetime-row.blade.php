@props([
    'label' => null,
    'id' => null,
    'model' => null,
    'placeholder' => '',
])

<div class="form-group row">
    @if ($label)
        <label for="{{ $id }}" class="col-sm-3 col-form-label">{{ $label }}</label>
    @endif

    <div class="col-sm-9">
        <div class="input-group date" id="{{ $id }}" data-target-input="nearest">
            <input 
                {{ $attributes->merge(['class' => 'form-control datetimepicker-input']) }}
                @if ($model)
                    wire:model.defer="{{ $model }}"
                @endif
                type="text" 
                data-target="#{{ $id }}" 
            />
            <div class="input-group-append" data-target="#{{ $id }}" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>

        @error($id)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

@push('js')
    <script>
        $(function () {
            $('#{{ $id }}').datetimepicker({
                format: 'YYYY-MM-DD',
                allowInputToggle: true,
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right",
                    today: "fa fa-screenshot",
                    clear: "fa fa-trash",
                    close: "fa fa-remove"
                }
            });

            $('#{{ $id }}').on('change.datetimepicker', function(e) {
                // console.log(e.date);
                if(!e.date){
                    @this.set('{{ $model }}', '');
                }else{
                    @this.set('{{ $model }}', e.date.format('YYYY-MM-DD'));
                }
            });

            Livewire.hook('message.processed', (message, component) => {
                $('#{{ $id }}').datetimepicker({
                    format: 'YYYY-MM-DD',
                    allowInputToggle: true,
                    icons: {
                        time: "fa fa-clock",
                        date: "fa fa-calendar",
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down",
                        previous: "fa fa-chevron-left",
                        next: "fa fa-chevron-right",
                        today: "fa fa-screenshot",
                        clear: "fa fa-trash",
                        close: "fa fa-remove"
                    }
                });
            });
        });
    </script>
@endpush