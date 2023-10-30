<div>
    <div class="d-flex flex-row justify-content-end" style="gap: 10px">
        <div wire:loading class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <select wire:model='selectedYear' class="form-control w-25" name="year" id="year">
           @foreach($years as $value)
              <option wire:loading.attr='disabled' value="{{$value}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div wire:init='dataset'>
        <canvas id="lineKeu"></canvas>
    </div>
</div>

@push('js')
<script>
    // console.log(@json($dataset));
    var progress = document.getElementById('animationProgress');
    const lineKeu = new Chart(
        document.getElementById('lineKeu'),{
            type: 'line',
            data: {
                labels: @json($label),
                datasets: @json($dataset),
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        align: 'bottom',
                        backgroundColor: '#ccc',
                        borderRadius: 3,
                        font: {
                            size: 18,
                        },
                    },
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                if(parseInt(value) >= 1000){
                                    return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                } else {
                                    return 'Rp. ' + value;
                                }
                            }
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: true,
            }
        },
    );

    Livewire.on('updateKeuanganChart', data => {
        lineKeu.data.datasets = data;
        lineKeu.update();
    })
</script>
@endpush
