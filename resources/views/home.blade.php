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
                <div class="d-flex justify-content-between">
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
                                    labels: months,
                                    datasets: [{
                                        label: 'Nº de ocorrências',
                                        data: [
                                            @foreach ($months as $month)
                                                '{{ $month->total }}',
                                            @endforeach
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
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
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
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
