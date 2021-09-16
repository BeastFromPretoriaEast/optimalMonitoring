<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Optimal Monitoring</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/darkly/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/darkly/darkUnica.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">

        <div class="card mt-3 mb-0">
            <div class="card-header">
                <h5 class="mb-0">
                    Energy consumption from  <span class="text-info">{{ $start_date }}</span> until <span class="text-info">{{ $end_date }}</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="line-chart"></div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .container -->

</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $(function(){

        document.querySelector("body").requestFullscreen();
        var chartHeight =  screen.height - 105  + 'px';

        Highcharts.chart('line-chart', {
            chart: {
                type: 'areaspline',
                height: chartHeight,
                style: {
                    fontFamily: 'Poppins',
                    fontWeight: 'normal',
                    paddingBottom: '10px',
                    paddingTop: '10px',
                    backgroundColor : '#2a2a2b'
                },
                tooltip: {
                    backgroundColor: '#FCFFC5',
                    borderColor: 'black',
                    borderRadius: 10,
                    borderWidth: 3
                }
            },
            tooltip: {
                backgroundColor: "rgba(246, 246, 246, 1)",
                borderRadius: 10,
                borderWidth: 1.5,
                style: {
                    opacity: 1,
                    background: "rgba(246, 246, 246, 1)",
                    color: "rgba(204, 204, 204, 1)"
                },
            },
            legend: {
                itemStyle: {
                    fontWeight: "normal",
                    color: '#CCC',
                }
            },
            title: {
                text: null,
            },
            yAxis: {
                title: {
                    text: 'Meter Values'
                },
                max: 100,
                plotBands: [{
                    from: {{ $benchmark }},
                    to: 0,
                    color: 'rgba(0, 255, 0, .2)',
                    zIndex: 999,
                }]
            },
            xAxis: {
                categories: {!! $date_times !!},
                title: {
                    text: 'Dates and Time'
                }
            },
            series: {!! $data !!},
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            }

        });
    });
</script>
</html>