<div>
    <div class="d-flex flex-row justify-content-end" style="gap: 10px">
        <div wire:loading class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="col-md-4">
            <div class="d-flex flex-row" style="gap: 10px">
                <select wire:model='selectedJenis' class="form-control" name="year" id="year">
                    @foreach($jenis as $key => $value)
                       <option wire:loading.attr='disabled' value="{{$key}}">{{$value}}</option>
                     @endforeach
                 </select>
                <select wire:model='selectedYear' class="form-control" name="year" id="year">
                   @foreach($years as $value)
                      <option wire:loading.attr='disabled' value="{{$value}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div wire:init='dataset'>
        <canvas id="lineRalan"></canvas>
    </div>
</div>

@push('js')
<script>
    
    const lineRalan = new Chart(
        document.getElementById('lineRalan'),{
            type: 'bar',
            data: {
                labels: @json($label),
                datasets: @json($dataset),
            },
            options: {
                plugins: {
                    labels: {
                        render: 'value'
                    },
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                responsive: true,
            }
        },
    );

    Livewire.on('updateRalanChart', data => {
        lineRalan.data.datasets = data;
        lineRalan.update();
    })
</script>
@endpush
