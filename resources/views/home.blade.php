@extends('adminlte::page')


@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Você está logado!
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Gráficos</div>
                <div class="d-flex justify-content-around">
                    @php( $pattern[] = [
                        '#66CDAA',
                        '#00FF00',
                        '#006400',
                        '#EE82EE',
                        '#8B0000',
                        '#800000',
                        '#4682B4',
                        '#663399',
                        '#800080',
                        '#FFA500',
                        '#BA55D3',
                        '#BDB76B',
                        '#2E8B57',
                        '#FFFF00',
                        '#4169E1',
                        '#008B8B',
                        '#FF69B4',
                        '#00FFFF',
                        '#191970',
                        '#FF0000',
                        '#DB7093',
                    ] )
                    <div class="card-body">
                        <canvas id="bar" width="200" height="200"></canvas>
                        <script>
                            let months = [
                                @foreach ($months as $month)
                                '{{ $month->name }}',
                                @endforeach
                            ]
                            let barCanvas = document.getElementById('bar').getContext('2d');
                            let myChart = new Chart(barCanvas, {
                                type: 'bar',
                                resposive: true,
                                data: {
                                    datasets:
                                        [
                                        @php( $i = 0 )
                                        @foreach ($months as $month)
                                            {
                                            data: ['{{ $month->total }}'],
                                            label: ['{{ $month->name }}'],
                                            backgroundColor: '{{ $pattern[0][$i] }}',
                                            },
                                            @php( $i++ )
                                        @endforeach
                                    ],
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                    <div class="card-body">
                        <canvas id="doughnut" width="200" height="200"></canvas>
                        <script>
                            let doughnutCanvas = document.getElementById('doughnut').getContext('2d');
                            let myDoughnutChart = new Chart(doughnutCanvas, {
                                type: 'doughnut',
                                resposive: true,
                                data: {
                                    datasets: [{
                                        data: [
                                            @foreach ($natures as $nature)
                                            '{{ $nature->occurrences->count() }}',
                                            @endforeach
                                        ],
                                        @php( $i = 0 )
                                        backgroundColor: [
                                            @foreach ($natures as $nature)
                                                '{{ $pattern[0][$i] }}',
                                                @php( $i++ )
                                            @endforeach
                                        ]
                                    }],
                                    labels: [
                                        @foreach ($natures as $nature)
                                            '{{ $nature->name }}',
                                        @endforeach
                                    ]
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

