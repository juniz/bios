<div>
    <div class="d-flex flex-row justify-content-between" style="gap: 10px">
        <div class="col-md-6">
            <h4>Jumlah SDM</h4>
        </div>
        <div class="col-md-5">
            <div class="d-flex flex-row" style="gap:10px">
                <div wire:loading class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <select wire:model='selectedJenis' class="form-control" name="jenis" id="jenis">
                    @foreach($jenis as $key => $value)
                    <option wire:loading.attr='disabled' value="{{$key}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row jutify-content-center">
        <div wire:init='data("{{$selectedJenis}}")' class="my-4 mx-auto">
            <canvas id="pieSDM" width="300" height="300"></canvas>
        </div>
    </div>
</div>

@push('js')
<script>
    const myChart = new Chart(
        document.getElementById('pieSDM'),{
            type: 'pie',
            data: {
                labels: @json($label),
                datasets: @json($dataset),
            },
            options: {
                plugins: {
                    labels: [
                        {
                          render: 'label',
                          position: 'outside'
                        },
                        {
                            render: 'value',
                            fontSize: 14,
                            fontStyle: 'bold',
                            fontColor: ['white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white'],
                        },
                    ]
                    // datalabels: {
                    //     display: true,
                    //     align: 'bottom',
                    //     backgroundColor: '#ccc',
                    //     borderRadius: 3,
                    //     font: {
                    //         size: 18,
                    //     },
                    //     formatter: function(value, context) {
                    //         return context.chart.data.labels[context.dataIndex];
                    //     }
                    // }
                },
                responsive: false,
                maintainAspectRatio: false
            }
        },
    );

    Livewire.on('updateSDM', data => {
        myChart.data.datasets = data;
        myChart.update();
        // myChart.resize(500, 500);
    })
</script>
@endpush
