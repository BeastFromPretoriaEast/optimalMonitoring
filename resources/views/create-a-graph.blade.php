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

    <div class="container">

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    Create a graph
                </h5>
            </div>

            <div class="card-body">

                <form method="get">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-4 col-form-label">Start Date:</label>
                                <div class="col-sm-8">
                                    <input type="date" id="startDate" name="start_date" value="{{ $start_date }}" max="{{ $max_date }}" min="{{ $min_date }}" class="form-control" placeholder="Start Date..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end_date" class="col-sm-4 col-form-label">End Date:</label>
                                <div class="col-sm-8">
                                    <input type="date" id="endDate" name="end_date" value="{{ $end_date }}" max="{{ $max_date }}" min="{{ $start_date }}" class="form-control" placeholder="End Date..." required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="benchmark" class="col-sm-4 col-form-label">Benchmark Value:</label>
                                <div class="col-sm-8">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-9 p-2 pl-3">
                                                <input type="range" id="benchmark" name="benchmark" value="{{ $benchmark }}" class="form-control-range" min="0" max="100" oninput="this.form.amountInput.value=this.value">
                                            </div>
                                            <div class="col-3">
                                                <input type="text" id="amountInput" value="{{ $benchmark }}" class="form-control form-control-sm text-center" value="0" oninput="this.form.amountRange.value=this.value" readonly />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="row  mb-2">
                                <div class="col-sm-4">
                                    Meters
                                </div>
                                <div class="col-sm-8">
                                    @foreach($meters as $meter)
                                        <div class="form-check">
                                            <input class="form-check-input" name="meters[]" type="checkbox" value="{{ $meter->id }}" @if(in_array($meter->id, $selected_meters)) checked @endif>
                                            <label class="form-check-label">
                                                Meter {{ $meter->serial_number }} <span> ( <span style="color: {{ $meter->color }}">&bull;</span> <span class="opacity-75">{{ $meter->name }}</span> )</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary">Generate graph</button>
                        </div>

                    </div><!-- .row -->

                </form>
            </div><!-- .card-body -->
        </div><!-- .card-body -->

        <div class="card my-4 ">
            <div class="card-header">
                <h5 class="mb-0">
                    Graph preview
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="line-chart"></div>
                    </div>
                    <div class="col-sm-12 text-right">
                        <a href="{{ route('graph.display') . $_SERVER['REQUEST_URI'] }}" id="shareGraphBtn" type="button" class="btn btn-primary mt-3">
                            Share graph
                        </a>
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
        Highcharts.chart('line-chart', {
            chart: {
                type: 'areaspline',
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

    $('#startDate').change(function() {
        $startDate = $('#startDate').val();
        $endDate = $('#endDate').val();

        $('#endDate').attr("min", $startDate);

        if($startDate > $endDate) {
            $('#endDate').val($startDate);
        }
    });

    $('input').change(function() {
        $('#shareGraphBtn').prop("disabled",true)
            .css("cursor", 'not-allowed')
            .removeClass("btn-primary")
            .addClass('btn-secondary');
    });
</script>
</html>