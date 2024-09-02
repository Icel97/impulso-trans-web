@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <div id="content">
        <div class="card">
            <div class="card-header">
                <h1>Métricas</h1>
            </div>
            <div class="card-body">
                <div style="max-height: 80vh; overflow-y: auto; overflow-x: hidden" class="flex flex-column gap-3">
                    <div class="row">
                        <div class="col-md-6">
                            <select id="year-select-afiliaciones" class="form-control" style="width: 200px;">
                                @php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year >= 2023; $year--) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                @endphp
                            </select>
                            <div id="loading-afiliaciones" class="loading-spinner"></div>
                            <div class="chart-wrapper" style="display:none;" id="chart-afiliaciones-wrapper">
                                <canvas id="chart-afiliaciones"></canvas>
                            </div>
                            <div id="error-afiliaciones" class="error-message"></div>
                        </div>
                        <div class="col-md-6">
                            <select id="year-select-citas" class="form-control" style="width: 200px;">
                                @php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year >= 2023; $year--) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                @endphp
                            </select>
                            <div id="loading-citas" class="loading-spinner"></div>
                            <div class="chart-wrapper" style="display:none;" id="chart-citas-wrapper">
                                <canvas id="chart-citas"></canvas>
                            </div>
                            <div id="error-citas" class="error-message"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="loading-pronombres" class="loading-spinner"></div>
                            <div class="chart-wrapper" style="display:none;" id="chart-pronombres-wrapper">
                                <canvas id="chart-pronombres"></canvas>
                            </div>
                            <div id="error-pronombres" class="error-message"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="loading-identidades" class="loading-spinner"></div>
                            <div class="chart-wrapper" style="display:none;" id="chart-identidades-wrapper">
                                <canvas id="chart-identidades"></canvas>
                            </div>
                            <div id="error-identidades" class="error-message"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="loading-afros" class="loading-spinner"></div>
                            <div class="chart-wrapper" style="display:none;" id="chart-afros-wrapper">
                                <canvas id="chart-afros"></canvas>
                            </div>
                            <div id="error-afros" class="error-message"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="loading-afiliados" class="loading-spinner"></div>
                            <div class="chart-wrapper flex justify-center" style="display:none;"
                                id="chart-afiliados-wrapper">
                                <canvas id="chart-afiliados"></canvas>
                            </div>
                            <div id="error-afiliados" class="error-message"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="loading-estados" class="loading-spinner"></div>
                            <div class="chart-wrapper-complete" style="display:none;" id="chart-estados-wrapper">
                                <canvas id="chart-estados"></canvas>
                            </div>
                            <div id="error-estados" class="error-message">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('css')
        <style>
            .chart-wrapper {
                width: 100%;
                height: 300px;
                min-height: 300px;
                min-width: 500px;
            }

            .chart-wrapper-complete {
                width: 100%;
                height: 300px;
                min-height: 300px;
                min-width: 700px;
            }

            #chart-estados {
                width: 100%;
                max-width: none;
                min-width: 700px;
            }

            .loading-spinner {
                width: 100%;
                height: 300px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .loading-spinner::after {
                content: "";
                width: 40px;
                height: 40px;
                border: 4px solid rgba(0, 0, 0, 0.1);
                border-left-color: #5bcefa;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .error-message {
                color: red;
                text-align: center;
                margin-top: 10px;
            }
        </style>

    @stop
    @section('js')
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
        <script>
            function fetchData(url, year, chartId, updateChartFn, errorMessageId, loadingId, chartWrapperId) {
                return $.ajax({
                    url: url,
                    data: {
                        year: year
                    },
                    success: function(data) {
                        $(`#${loadingId}`).hide();
                        $(`#${chartWrapperId}`).show();
                        updateChartFn(data);
                    },
                    error: function() {
                        $(`#${loadingId}`).hide();
                        $(`#${errorMessageId}`).text("Error al cargar los datos.");
                    }
                });
            }

            function updateChart_asesorias(data) {
                const values = Object.values(data);
                const labels = Object.keys(data);

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Aprobadas',
                        data: values,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }]
                };

                const ctx = document.getElementById('chart-afiliaciones').getContext('2d');
                const subtitle = $('#year-select-afiliaciones option:selected').text();

                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : null;
                                    }
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Afiliaciones Aprobadas'
                            },
                            subtitle: {
                                display: true,
                                text: subtitle
                            },
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: 'rgb(255, 99, 132)'
                                }
                            }
                        }
                    }
                };

                if (window.chart_asesorias) {
                    window.chart_asesorias.destroy();
                }

                window.chart_asesorias = new Chart(ctx, config);
            }

            function updateChart_citas(data) {
                const labels = Object.keys(data.citas_canceladas);
                const canceladas = Object.values(data.citas_canceladas);
                const finalizadas = Object.values(data.citas_finalizadas);
                const pendientes = Object.values(data.citas_pendientes);

                const chartData = {
                    labels: labels,
                    datasets: [{
                            label: 'Citas Canceladas',
                            data: canceladas,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Citas Finalizadas',
                            data: finalizadas,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Citas Pendientes',
                            data: pendientes,
                            backgroundColor: 'rgba(255, 206, 86, 0.5)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }
                    ]
                };

                const ctx = document.getElementById('chart-citas').getContext('2d');
                const subtitle = $('#year-select-citas option:selected').text();

                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Citas'
                            },
                            subtitle: {
                                display: true,
                                text: subtitle
                            },
                        },
                        responsive: true,
                    }
                };

                if (window.chart_citas) {
                    window.chart_citas.destroy();
                }

                window.chart_citas = new Chart(ctx, config);
            }

            function updateChart_estados(data) {
                const labels = data.map(item => item.estado); // Extract state names
                const values = data.map(item => item.total_usuarios); // Extract user counts

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Usuarios',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                };

                const ctx = document.getElementById('chart-estados').getContext('2d');
                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    autoSkip: false, // Prevents skipping labels
                                    maxRotation: 90, // Rotate labels for better fit
                                    minRotation: 45, // Minimum rotation if there's enough space
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : null;
                                    }
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false, // Allows the chart to resize correctly
                        plugins: {
                            title: {
                                display: true,
                                text: 'Usuarios por Estado'
                            },
                            legend: {
                                display: false,
                                position: 'top',
                                labels: {
                                    color: 'rgb(54, 162, 235)'
                                }
                            }
                        }
                    }
                };

                if (window.chart_estados) {
                    window.chart_estados.destroy();
                }

                window.chart_estados = new Chart(ctx, config);
            }

            function updateChart_identidades(data) {

                const labels = data.identidades.map(item => item.identidad_genero);
                labels.unshift('Total usuarios');
                const usuarios_totales = data.total_usuarios;
                const identidadesValues = data.identidades.map(item => item.total_usuarios);
                identidadesValues.unshift(usuarios_totales);

                const identidadesChartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Usuarios por Identidad de Género',
                        data: identidadesValues,
                        backgroundColor: ['rgba(153, 102, 255, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                        ],
                        borderColor: ['rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                };

                const ctxIdentidades = document.getElementById('chart-identidades').getContext('2d');
                const identidadesConfig = {
                    type: 'bar',
                    data: identidadesChartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : null;
                                    }
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Usuarios por Identidad de Género'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                };

                if (window.chartIdentidades) {
                    window.chartIdentidades.destroy();
                }
                window.chartIdentidades = new Chart(ctxIdentidades, identidadesConfig);
            }

            function updateChart_pronombres(data) {
                // Pronombres Chart

                const labels = data.pronombres.map(item => item.pronombres);
                labels.unshift('Total de usuarios');
                const usuarios_totales = data.total_usuarios
                const pronombresValues = data.pronombres.map(item => item.total_usuarios);
                pronombresValues.unshift(usuarios_totales);

                console.log(" pronombresValues", pronombresValues);



                const pronombresChartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Usuarios',
                        data: pronombresValues,
                        backgroundColor: ['rgba(75, 192, 192, 0.5)',
                            'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                const ctxPronombres = document.getElementById('chart-pronombres').getContext('2d');
                const pronombresConfig = {
                    type: 'bar',
                    data: pronombresChartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : null;
                                    }
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Usuarios por Pronombres'
                            },
                            legend: {
                                display: false
                            },
                            customCanvasBackgroundColor: {
                                color: 'lightGreen',
                            }
                        }
                    }
                };

                if (window.chartPronombres) {
                    window.chartPronombres.destroy();
                }
                window.chartPronombres = new Chart(ctxPronombres, pronombresConfig);

            }

            function updateChart_afros(data) {
                const labels = ["Total usuarios", "Afrodescendientes", "Indígenas", "Neurodivergentes"];
                const total_usuarios = data.total_usuarios;
                const total_afros = data.afrodescendientes;
                const total_indigenas = data.indigenas;
                const total_neurodivergentes = data.neurodivergentes;

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Usuarios',
                        data: [total_usuarios, total_afros, total_indigenas, total_neurodivergentes],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.5)', // Color para Total de Usuarios
                            'rgba(255, 99, 132, 0.5)', // Color para Afrodescendientes
                            'rgba(54, 162, 235, 0.5)' // Color para Indígenas
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)', // Color para Total de Usuarios
                            'rgba(255, 99, 132, 1)', // Color para Afrodescendientes
                            'rgba(54, 162, 235, 1)' // Color para Indígenas
                        ],
                        borderWidth: 1
                    }]
                };

                const ctx = document.getElementById('chart-afros').getContext('2d');

                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Afrodescendientes - Indígenas - Neurodivergentes'
                            },
                            legend: {
                                display: false
                            }
                        },
                        responsive: true,
                    }
                };

                if (window.chartAfros) {
                    window.chartAfros.destroy();
                }

                window.chartAfros = new Chart(ctx, config);
            }

            function updateChart_afiliados(data) {
                const labels = ["Afiliados", "Sin Afiliación"];
                const total_usuarios = data.total_usuarios;
                const total_afiliados = data.afiliados;
                const total_no_afiliados = total_usuarios - total_afiliados;
                // i want a pie chart

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Usuarios',
                        data: [total_afiliados, total_no_afiliados],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.5)', // Color para Total de Usuarios
                            'rgba(255, 99, 132, 0.5)', // Color para Afrodescendientes
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)', // Color para Total de Usuarios
                            'rgba(255, 99, 132, 1)', // Color para Afrodescendientes
                        ],
                        borderWidth: 1

                    }]
                };

                //pie chart
                const ctx = document.getElementById('chart-afiliados').getContext('2d');

                const config = {
                    type: 'pie',
                    data: chartData,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Usuarios Afiliados'
                            },
                            legend: {
                                display: true,
                                position: 'right',
                                labels: {
                                    color: 'rgb(255, 99, 132)'
                                }
                            }
                        }
                    }
                };

                if (window.chartAfiliados) {
                    window.chartAfros2.destroy();
                }

                window.chartAfiliados = new Chart(ctx, config);


            }

            $(document).ready(function() {
                const currentYearAsesorias = $('#year-select-afiliaciones').val();
                const currentYearCitas = $('#year-select-citas').val();

                // Fetch each chart data individually
                fetchData('/api/metricas/afiliaciones', currentYearAsesorias, 'chart-afiliaciones',
                    updateChart_asesorias, 'error-afiliaciones', 'loading-afiliaciones',
                    'chart-afiliaciones-wrapper');
                fetchData('/api/metricas/citas', currentYearCitas, 'chart-citas', updateChart_citas, 'error-citas',
                    'loading-citas', 'chart-citas-wrapper');
                fetchData('/api/metricas/usuario_residencia', null, 'chart-estados', updateChart_estados,
                    'error-estados', 'loading-estados', 'chart-estados-wrapper');
                fetchData('/api/metricas/usuario_identidades', null, 'chart-identidades', updateChart_identidades,
                    'error-identidades', 'loading-identidades', 'chart-identidades-wrapper');
                fetchData('/api/metricas/usuario_pronombres', null, 'chart-pronombres', updateChart_pronombres,
                    'error-pronombres', 'loading-pronombres', 'chart-pronombres-wrapper');
                fetchData('/api/metricas/usuario_afro_indigena', null, 'chart-afros', updateChart_afros, 'error-afros',
                    'loading-afros', 'chart-afros-wrapper');
                fetchData('/api/metricas/usuarios_afiliados', null, 'chart-afiliados', updateChart_afiliados,
                    'error-afiliados', 'loading-afiliados', 'chart-afiliados-wrapper');

                $('#year-select-afiliaciones').on('change', function() {
                    const selectedYear = $(this).val();
                    fetchData('/api/metricas/afiliaciones', selectedYear, 'chart-afiliaciones',
                        updateChart_asesorias, 'error-afiliaciones', 'loading-afiliaciones',
                        'chart-afiliaciones-wrapper');
                });

                $('#year-select-citas').on('change', function() {
                    const selectedYear = $(this).val();
                    fetchData('/api/metricas/citas', selectedYear, 'chart-citas', updateChart_citas,
                        'error-citas', 'loading-citas', 'chart-citas-wrapper');
                });
            });
        </script>

    @stop
