<div class="card">
    <div class="card-body">
        <h5 class="card-title">Title</h5>
        <div id="chartCard"></div>
    </div>
</div>

@push('js')
<script>
    var chart = new ApexCharts(document.querySelector('#chartCard'), {
        chart: {
            type: 'line',
            height: 100,
            width: '100%',
            toolbar: {
                show: false
            },
        },
        series: [{
            name: 'sales',
            data: [30,40,35,50,49,60,70,91,125]
        }],
        xaxis: {
            categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999],
            labels: {
                show: false
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        grid: {
            show: false
        },
        yaxis: {
            show: false,
            line: {
                show: false
            }
        },
        legend: {
            show: false
        },
    });

    chart.render();
</script>
@endpush
