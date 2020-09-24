@extends('adminlte::page')


@section('content')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('message', ['message' => $message ?? ''])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-center">
                            <h3>Ocorrências por mês</h3>
                        </div>
                    </div>
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
                                                @php($i = 0)
                                                @foreach ($months as $month)
                                            {
                                                data: ['{{ $month->total }}'],
                                                label: ['{{ $month->name }}'],
                                                backgroundColor: [
                                                    '{{ $colors[$i] }}',
                                                ],
                                                @if($i == count($colors))
                                                @php($i = 0)
                                                @else
                                                @php($i++)
                                                    @if($i > 4)
                                                        @php($i = 0)
                                                    @endif
                                                @endif
                                            },
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
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-center">
                            <h3>Ocorrências por natureza</h3>
                        </div>
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
                                        backgroundColor: [
                                            @foreach($colors as $color)
                                                '{{$color}}',
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
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-center">
                            <h3>Ocorrências por mês</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="bar2" width="200" height="200"></canvas>
                        <script>
                            let bairros = [
                                @foreach ($bairros as $bairro)
                                    '{{ $bairro->name }}',
                                @endforeach
                            ]
                            let bar2Canvas = document.getElementById('bar2').getContext('2d');
                            let myChart2 = new Chart(bar2Canvas, {
                                type: 'bar',
                                resposive: true,
                                data: {
                                    datasets:
                                        [
                                                @php($i = 0)
                                                @foreach ($bairros as $bairro)
                                            {
                                                data: ['{{ $bairro->total }}'],
                                                label: ['{{ $bairro->name }}'],
                                                backgroundColor: [
                                                    '{{ $colors[$i] }}',
                                                ],
                                                @if($i == count($colors))
                                                @php($i = 0)
                                                @else
                                                @php($i++)
                                                    @if($i > 4)
                                                    @php($i = 0)
                                                    @endif
                                                @endif
                                            },
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
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-center">
                            <h3>Ocorrências por natureza</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="pie" width="200" height="200"></canvas>
                        <script>
                            let pieCanvas = document.getElementById('pie').getContext('2d');
                            let myPieChart = new Chart(pieCanvas, {
                                type: 'pie',
                                resposive: true,
                                data: {
                                    datasets: [{
                                        data: [
                                            @foreach ($types as $type)
                                                '{{ $type->occurrences->count() }}',
                                            @endforeach
                                        ],
                                        backgroundColor: [
                                            @foreach($colors as $color)
                                                '{{$color}}',
                                            @endforeach
                                        ]
                                    }],
                                    labels: [
                                        @foreach ($types as $type)
                                            '{{ $type->name }}',
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
@endsection

