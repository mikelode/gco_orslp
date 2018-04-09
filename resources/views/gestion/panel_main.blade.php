@extends('../app')

@section('main-content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-primary mb-1" role="alert">
                Bienvenido, {{ $usuario }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-transparent caption-header">Administración de Contratos</div>
                <div class="card-table table-responsive">
                    <table class="table table-hover align-middle" id="table-sparkline">
                        <thead class="thead-light">
                            <tr>
                                <th>Obra por Contrata</th>
                                <th>Proceso</th>
                                <th>Última Valorización</th>
                                <th>Acumulado</th>
                                <th>Rendimiento</th>
                                <th>Evolución</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-sparkline">
                            @foreach($dashboard as $i => $py)
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="heading mt-1">
                                                {{ $py->pryShortDenomination }}
                                            </div>
                                            <div class="subtext">
                                                {{ 'SNIP: ' . $py->prySnip . "/ CU: " . $py->pryUnifiedCode }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">{{ $py->prgStatus }}</span>
                                </td>
                                <td>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="heading mt-1">
                                                {{ 'Valorizacion Nro: ' . $py->prgNumberVal }}
                                            </div>
                                            <div class="subtext">
                                                {{ 'Periodo: ' . $py->prgStartPeriod . ' a ' . $py->prgEndPeriod }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ number_format($py->prgAggregateExec * 100,2,'.',',') }}
                                </td>
                                <td>
                                    @if($py->prgPerformance >= 90)
                                    <span class="badge badge-success" style="font-size: 1rem">{{ $py->prgPerformance }}</span>
                                    @elseif($py->prgPerformance < 90 && $py->prgPerformance > 80)
                                    <span class="badge badge-warning" style="font-size: 1rem">{{ $py->prgPerformance }}</span>
                                    @elseif($py->prgPerformance <= 80)
                                    <span class="badge badge-danger" style="font-size: 1rem">{{ $py->prgPerformance }}</span>
                                    @endif
                                    
                                </td>
                                <td data-sparkline="{!! $py->prgProgress !!} ; column"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
Highcharts.SparkLine = function (a, b, c) {
    var hasRenderToArg = typeof a === 'string' || a.nodeName,
        options = arguments[hasRenderToArg ? 1 : 0],
        defaultOptions = {
            chart: {
                renderTo: (options.chart && options.chart.renderTo) || this,
                backgroundColor: null,
                borderWidth: 0,
                type: 'area',
                margin: [2, 0, 2, 0],
                width: 120,
                height: 20,
                style: {
                    overflow: 'visible'
                },

                // small optimalization, saves 1-2 ms each sparkline
				skipClone: true
			},
			exporting: { enabled: false },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                startOnTick: false,
                endOnTick: false,
                tickPositions: []
            },
            yAxis: {
                endOnTick: false,
                startOnTick: false,
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                tickPositions: [0]
            },
            legend: {
                enabled: false
            },
            tooltip: {
                backgroundColor: null,
                borderWidth: 0,
                shadow: false,
                useHTML: true,
                hideDelay: 0,
                shared: true,
                padding: 0,
                positioner: function (w, h, point) {
                    return { x: point.plotX - w / 2, y: point.plotY - h };
                }
            },
            plotOptions: {
                series: {
                    animation: false,
                    lineWidth: 1,
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    marker: {
                        radius: 1,
                        states: {
                            hover: {
                                radius: 2
                            }
                        }
                    },
                    fillOpacity: 0.25
                },
                column: {
                    negativeColor: '#910000',
                    borderColor: 'silver'
                }
            }
        };

    options = Highcharts.merge(defaultOptions, options);

    return hasRenderToArg ?
        new Highcharts.Chart(a, options, c) :
        new Highcharts.Chart(options, b);
};

var $tds = $('td[data-sparkline]'),
    n = 0;

// Creating 153 sparkline charts is quite fast in modern browsers, but IE8 and mobile
// can take some seconds, so we split the input into chunks and apply them in timeouts
// in order avoid locking up the browser process and allow interaction.
function doChunk() {
    var time = +new Date(),
        i,
        len = $tds.length,
        $td,
        stringdata,
        arr,
        data,
        chart;

    for (i = 0; i < len; i += 1) {
        $td = $($tds[i]);
        stringdata = $td.data('sparkline');
        arr = stringdata.split('; ');
        data = $.map(arr[0].split(', '), parseFloat);
        chart = {};

        if (arr[1]) {
            chart.type = arr[1];
        }
        $td.highcharts('SparkLine', {
            series: [{
                data: data,
                pointStart: 1
            }],
            tooltip: {
                headerFormat: '<span style="font-size: 10px">' + $td.parent().find('th').html() + ', V{point.x}:</span><br/>',
                pointFormat: '<b>{point.y}</b>'
            },
            chart: chart
        });

        n += 1;

        // If the process takes too much time, run a timeout to allow interaction with the browser
        if (new Date() - time > 500) {
            $tds.splice(0, i + 1);
            setTimeout(doChunk, 0);
            break;
        }
    }
}
doChunk();
</script>

@endsection