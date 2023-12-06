<div>
    <form action="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_rekening">No. Rekening</label>
                    <input id="no_rekening" class="form-control" type="text" name="no_rekening">
                </div>
            </div>
            <div class="col-md-6">
                <div wire:ignore.self wire:init='bankUpdated' class="form-group">
                    <label for="kdBank">Bank 
                        <div wire:loading='bankUpdated' class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </label>
                    <select id="kdBank" class="form-control" type="text" name="kdBank" >
                        <option value="">Pilih Bank</option>
                        {{-- @foreach($bank as $item)
                        <option value="{{$item['kode']}}">{{$item['kode']}} - {{$item['uraian']}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div wire:ignore.self class="form-group">
                    <label for="no_rekening">Rekening</label>
                    <select id="no_rekening" class="form-control" type="text" name="no_rekening">
                        <option value="">Pilih No Rekening</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

@push('js')
<script>
    $('#kdBank').select2({
        placeholder: 'Pilih Bank',
        allowClear: true,
    });
    $('#no_rekening').select2({
        placeholder: 'Pilih No Rekening',
        allowClear: true,
    });
    Livewire.on('bankUpdated', data => {
        let bank = data.map(item => {
            return {
                id: item.kode,
                text: item.kode + ' - ' + item.uraian
            }
        });
        $('#kdBank').select2({
            placeholder: 'Pilih Bank',
            allowClear: true,
            data: bank
        });
    });
</script>
@endpush
