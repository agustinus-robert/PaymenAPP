@extends('hrms::layouts.default')

@section('title', 'Dasbor | ')

@section('navtitle', 'Dasbor')

@php
    $charts = [
        [
            'name' => 'genderChart',
            'label' => 'Karyawan berdasarkan jenis kelamin',
            'icon' => 'mdi mdi-gender-male-female',
            'data' => $employee_by_genders,
            'type' => 'pie',
            'row' => 4,
            'height' => '40vh',
        ],
        [
            'name' => 'contractChart',
            'label' => 'Karyawan berdasarkan jenis perjanjian kerja',
            'icon' => 'mdi mdi-file-document-multiple-outline',
            'data' => $employee_by_contracts,
            'type' => 'pie',
            'row' => 4,
            'height' => '40vh',
        ],
        [
            'name' => 'educationChart',
            'label' => 'Karyawan berdasarkan jenis pendidikan',
            'icon' => 'mdi mdi-school-outline',
            'data' => $employee_by_educations,
            'type' => 'pie',
            'row' => 4,
            'height' => '40vh',
        ],
        [
            'name' => 'religionChart',
            'label' => 'Karyawan berdasarkan agama',
            'icon' => 'mdi mdi-hand-heart',
            'data' => $employee_by_religions,
            'type' => 'pie',
            'row' => 4,
            'height' => '40vh',
        ],
        [
            'name' => 'departmentChart',
            'label' => 'Karyawan berdasarkan departemen',
            'icon' => 'mdi mdi-link-box-variant-outline',
            'data' => $employee_by_departements,
            'type' => 'bar',
            'row' => 8,
            'height' => '40vh',
        ],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
                        <div>
                            <img class="w-100" src="{{ asset('img/manypixels/Welcome.svg') }}" alt="" style="height: 140px;">
                        </div>
                        <div class="order-md-first text-md-start text-center">
                            <div class="px-4 py-3">
                                <h2 class="fw-normal">Selamat datang {{ Auth::user()->name }}!</h2>
                                <div class="text-muted">di {{ config('modules.hrms.name') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($charts as $key => $value)
            <div class="col-md-{{ $value['row'] }}">
                <div class="card border-0">
                    <div class="card-body border-bottom"><i class="{{ $value['icon'] }}"></i> {{ $value['label'] }}</div>
                    <div class="chart-container" style="height: {{ $value['height'] }}; width:100%;">
                        <canvas id="{{ $value['name'] }}" class="custom-chart"></canvas>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .custom-chart {
            max-width: 100%;
            /* Ensure the chart does not overflow its container */
            max-height: 100%;
            /* Ensure the chart stays within the container's height */
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const charts = {!! json_encode($charts) !!};

        // Function to create chart data
        function createChartData(dataValues, label) {
            return {
                labels: Object.keys(dataValues),
                datasets: [{
                    label: label,
                    data: Object.values(dataValues),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(90, 199, 90, 0.7)',
                        'rgba(63, 43, 173, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(90, 199, 90, 1)',
                        'rgba(63, 43, 173, 1)',
                    ],
                    borderWidth: 1
                }]
            };
        }

        // Custom legend generation function to display values and percentages
        function generateLegendLabels(chart) {
            const data = chart.data.datasets[0].data;
            const total = data.reduce((sum, value) => sum + value, 0);

            return chart.data.labels.map((label, index) => {
                const value = data[index];
                const percentage = ((value / total) * 100).toFixed(2);

                // Return an object with the text and other properties
                return {
                    text: `${label}: ${value} (${percentage}%)`,
                    fillStyle: chart.data.datasets[0].backgroundColor[index], // Color for the legend box
                    hidden: false, // If you want to allow hiding by clicking on legend
                    index: index // Store index
                };
            });
        }

        // Function to create and render a chart
        function createChart(ctx, chartData, chartType) {
            return new Chart(ctx, {
                type: chartType, // Set chart type
                data: chartData,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom', // Set the legend position to 'left'
                            labels: {
                                generateLabels: (chart) => {
                                    return generateLegendLabels(chart); // Use custom legend generation
                                }
                            }
                        }
                    }
                }
            });
        }

        // Loop through each chart configuration and render the chart
        charts.forEach(chart => {
            const chartData = createChartData(chart.data, chart.label);
            const ctx = document.getElementById(chart.name);
            if (ctx) {
                createChart(ctx, chartData, chart.type || 'pie'); // Default to 'pie' if no type specified
            }
        });
    </script>
@endpush
