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
        <canvas id="lineIGD"></canvas>
    </div>
</div>

@push('js')
<script>
    
    const lineIGD = new Chart(
        document.getElementById('lineIGD'),{
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
                            beginAtZero: true
                        }
                    }]
                },
                responsive: true,
            },
        },
    );

    Livewire.on('updateIGDChart', data => {
        console.log(data);
        lineIGD.data.datasets = data;
        lineIGD.update();
    })
</script>
@endpush
