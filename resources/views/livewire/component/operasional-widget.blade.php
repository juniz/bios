<div>
    <div class="d-flex flex-row justify-content-between" style="gap: 10px">
        <div class="d-inline-flex">
            <h4>Saldo Rekening Operasional</h4>
        </div>
        <div class="col-md-7">
            <div class="d-inline-flex flex-row" style="gap:10px">
                <div wire:loading class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row jutify-content-center">
        <div wire:init='data' class="mx-auto">
            <canvas id="pieOperasional" width="1200" height="500"></canvas>
        </div>
    </div>
</div>

@push('js')
<script>
    const operasionalChart = new Chart(
        document.getElementById('pieOperasional'),{
            type: 'pie',
            data: {
                labels: @json($label),
                datasets: @json($dataset),
            },
            options: {
                legend: {
                    display: false
                },
                plugins: {
                    labels: [
                        {
                          render: 'label',
                          position: 'outside'
                        },
                        {
                            render: function (args) {
                                const value = args.value;
                                const formattedValue = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                                return formattedValue;
                            },
                            fontSize: 14,
                            fontStyle: 'bold',
                            fontColor: ['white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white'],
                        },
                    ],
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label + ': Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                },
                responsive: false,
                maintainAspectRatio: false
            }
        },
    );

    Livewire.on('updateOperasional', data => {
        operasionalChart.data.datasets = data;
        operasionalChart.update();
    })
</script>
@endpush
