@extends('adminlte::page')

@section('title', 'Impulso trans - Pagos')

@section('content_header')
    <h1> </h1>

@stop

@section('content')

    <x-adminlte-alert theme="success" title="Info" id="success-alert2" style="display: none;">
        {{ session('success') }}
    </x-adminlte-alert>
    <x-adminlte-alert theme="danger" title="Hubo un error" id="error-alert2" style="display: none;">
        {{ session('error') }}
    </x-adminlte-alert>


    <div id="loading" style="display: none;" class="justify-content-center align-self-center">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="200"
            height="200" style="shape-rendering: auto; display: block; background: rgb(255, 255, 255);"
            xmlns:xlink="http://www.w3.org/1999/xlink">
            <g>
                <circle stroke-width="8" stroke="#f5a9b8" fill="none" r="0" cy="50" cx="50">
                    <animate begin="0s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1" values="0;57"
                        dur="1.5625s" repeatCount="indefinite" attributeName="r"></animate>
                    <animate begin="0s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1" values="1;0"
                        dur="1.5625s" repeatCount="indefinite" attributeName="opacity"></animate>
                </circle>
                <circle stroke-width="8" stroke="#5bcefa" fill="none" r="0" cy="50" cx="50">
                    <animate begin="-0.78125s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1" values="0;57"
                        dur="1.5625s" repeatCount="indefinite" attributeName="r"></animate>
                    <animate begin="-0.78125s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1" values="1;0"
                        dur="1.5625s" repeatCount="indefinite" attributeName="opacity"></animate>
                </circle>
                <g></g>
            </g><!-- [ldio] generated by https://loading.io -->
        </svg>
    </div>

    <div id="content">
        <div class="card">
            <div class="card-header">
                <h1>Asesorias</h1>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'all']) }}">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'pending' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'Pendiente']) }}">Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'review' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'Confirmado']) }}">Por revisar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'approved' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'Cancelado']) }}">Aprobados</a>
                    </li>
                </ul>

                @if (session('success'))
                    <x-adminlte-alert theme="success" title="Info" id="success-alert">
                        {{ session('success') }}
                    </x-adminlte-alert>
                @elseif (session('error'))
                    <x-adminlte-alert theme="danger" title="Hubo un error" id="error-alert">
                        {{ session('error') }}
                    </x-adminlte-alert>
                @elseif (session('info'))
                    <x-adminlte-alert theme="info" title="Alerta" id="info-alert">
                        {{ session('info') }}
                    </x-adminlte-alert>
                @endif

                @if (sizeof($asesorias) > 0)
                    @php
                        $heads = [
                            'ID',
                            'Nombre',
                            'Apellidos',
                            'Telefono',
                            'Estatus',
                            ['label' => 'Detalle', 'no-export' => true, 'width' => 8],
                        ];
                        $config = [
                            'language' => [
                                'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                            ],
                            'order' => [[0, 'desc']],
                            'columns' => [null, null, null, null, ['orderable' => false], ['orderable' => false]],
                            'lengthMenu' => [25, 50, 100, 500],
                        ];
                    @endphp
                    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable compressed>
                        @foreach ($asesorias as $asesoria)
                            @php
                                $status = $asesoria->estatus;
                                $turnOffActionValidar = false;
                                $turnOffActionRechazar = false;
                                $rowClass = '';
                                if ($status == 'Confirmada') {
                                    $turnOffActionValidar = true;
                                    $rowClass = 'text-success';
                                } elseif ($status == 'Pendiente') {
                                    $turnOffActionRechazar = true;
                                    $rowClass = 'text-danger';
                                } else {
                                    $rowClass = '';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $asesoria->id }}</td>
                                <td>{{ $asesoria->user->name ?? '-' }}</td>
                                <td>{{ $asesoria->user->apellidos ?? '-' }}</td>
                                <td>{{ $asesoria->user->telefono ?? '-' }}</td>
                                <td>{{ $asesoria->estatus }}</td>
                                <td>
                                    <input type="hidden" name="action" id="action-{{ $asesoria->id }}">
                                    <input type="hidden" name="id" value="{{ $asesoria->id }}">
                                    <button type="button" class="btn mx-1 btn-info" title="Info" data-toggle="modal"
                                        data-target="#infoModal" data-id="{{ $asesoria->id }}">
                                        <i class="fas fa-lg fa-info-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                @else
                    <p class="text-muted">Aún no hay registros</p>

                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-2xl" id="newProductModalLabel">Información de Asesoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="form-loading" style="display: none;" class="justify-content-center align-self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"
                            width="200" height="200"
                            style="shape-rendering: auto; display: block; background: rgb(255, 255, 255);"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g>
                                <circle stroke-width="8" stroke="#f5a9b8" fill="none" r="0" cy="50"
                                    cx="50">
                                    <animate begin="0s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1"
                                        values="0;57" dur="1.5625s" repeatCount="indefinite" attributeName="r">
                                    </animate>
                                    <animate begin="0s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1"
                                        values="1;0" dur="1.5625s" repeatCount="indefinite" attributeName="opacity">
                                    </animate>
                                </circle>
                                <circle stroke-width="8" stroke="#5bcefa" fill="none" r="0" cy="50"
                                    cx="50">
                                    <animate begin="-0.78125s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1"
                                        values="0;57" dur="1.5625s" repeatCount="indefinite" attributeName="r">
                                    </animate>
                                    <animate begin="-0.78125s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1"
                                        values="1;0" dur="1.5625s" repeatCount="indefinite" attributeName="opacity">
                                    </animate>
                                </circle>
                                <g></g>
                            </g><!-- [ldio] generated by https://loading.io -->
                        </svg>
                    </div>
                    <form id="form-content" class="py-8" action="{{ route('asesorias.actualizar') }}" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" name="action" id="asesoria-id" value="">
                        <div class="row mx-n2">
                            <div class="col-md-6 mb-4 px-2">
                                <p class="font-weight-bold text-primary">Identidad de Genero</p>
                                <div class="bg-light rounded w-100 mr-2">
                                    <p id="identidad_genero" class="card-text">-</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 px-2">
                                <p class="font-weight-bold text-primary">Pronombre</p>
                                <div class="bg-light rounded w-100 mr-2">
                                    <p id="pronombres" class="card-text">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-n2">
                            <div class="col-md-6 mb-4 px-2">
                                <p class="font-weight-bold text-primary">Estatus</p>
                                <div class="bg-light rounded w-100 mr-2">
                                    <select id="estatus" class="form-control">
                                        @foreach ($estatus as $estado)
                                            <option value="{{ $estado }}">{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 px-2">
                                <p class="font-weight-bold text-primary">Motivo</p>
                                <div class="bg-light rounded w-100 mr-2">
                                    <p id="motivo" class="card-text">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-n2">
                            <div class="col-md-6 mb-4 px-2">
                                <p class="font-weight-bold text-primary">Cancelaciones</p>
                                <div class="bg-light rounded w-100 mr-2">
                                    <p id="canceladas" class="card-text">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-n2">
                            <div class="col-md-12 mb-4 px-2">
                                <p class="font-weight-bold text-primary">Notas</p>
                                <textarea id="notas" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <p id="error-message" class="text-danger"></p>


                    <x-adminlte-button label="Cerrar" theme="secondary" icon="fas fa-times" data-dismiss="modal" />
                    <x-adminlte-button id="submit-button" type="button" label="Guardar" theme="primary"
                        icon="fas fa-save" />
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        $(document).ready(function() {
            $('#loading').css('display', 'flex');
            $('#content').hide();
            $(window).on('load', function() {
                $('#loading').hide();
                $('#content').show();
            });

            @if ($errors->any())
                $('#newProductModal').modal('show');
            @endif

            // Hide alerts after 5 seconds
            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
                $('#error-alert').fadeOut('slow');
                $('#info-alert').fadeOut('slow');
            }, 5000);

            $('.formValidar').submit(function(e) {
                e.preventDefault();
                var action = '';
                var formId = $(this).find('input[name="action"]').attr('id');

                if ($(this).find('.btn-validate').is(':focus')) {
                    action = 'accepted';
                } else if ($(this).find('.btn-info').is(':focus')) {
                    action = 'rejected';
                }
                $('#' + formId).val(action);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: action === 'accepted' ? "Validar pago" : "Rechazar pago",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: action === 'accepted' ? '¡Sí, validar!' : '¡Sí, rechazar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                        $('#loading').css('display', 'flex');
                        $('#content').hide();
                    } else {
                        $('#loading').hide();
                        $('#content').show();
                    }
                });
            });

            $('#infoForm').submit(function() {
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
            });
            // Handle the click event for the details button
            $('body').on('click', '.btn-info', function() {
                $('#form-loading').css('display', 'flex');
                $('#submit-button').prop('disabled', true);
                $("#asesoria-id").val($(this).data('id'));
                $('#form-content').hide();
                var id = $(this).data('id');
                $.ajax({
                    url: '/api/asesorias/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#infoModal').find('.modal-body #identidad_genero').text(data.user
                            .identidad_genero ?? '-');
                        $('#infoModal').find('.modal-body #pronombres').text(data.user
                            .pronombres ??
                            '-');
                        $('#infoModal').find('.modal-body #estatus').val(data.estatus ?? '-');

                        $(
                            '#infoModal').find('.modal-body #motivo').text(data
                            .motivo ?? '-');
                        $('#infoModal').find('.modal-body #notas')
                            .val(data.notas ?? '-');
                        $('#submit-button').prop('disabled',
                            false);
                        $('#canceladas').text(data.user.cancelacion.total ?? '-');
                    },
                    error: function(data) {
                        console.error(data);
                        $('#infoModal').modal('hide');
                        $('#error-alert2').text(data.message);
                        $('#error-alert2').show();
                        $('#loading').css('display', 'flex');
                        $('#content').hide();
                        location.reload();

                    },
                    complete: function(data) {
                        $('#form-loading').hide();
                        $('#form-content').show();
                    }
                });
            });

            $('#submit-button').click(function() {
                $('#submit-button').prop('disabled', true);
                $('#form-content').hide();
                $('#form-loading').css('display', 'flex');
                $.ajax({
                    url: $('#form-content').attr('action'),
                    method: 'post',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        id: $('#asesoria-id').val(),
                        estatus: $('#estatus').val(),
                        notas: $('#notas').val(),
                    },
                    success: function(data) {
                        console.log("actualizado");
                        $('#infoModal').modal('hide');
                        $('#success-alert2').text(data.message);
                        $('#success-alert2').show();
                        $('#loading').css('display', 'flex');
                        $('#content').hide();
                        // location.reload();

                    },
                    error: function(data) {
                        console.error(data);
                        console.error(data);
                        $('#infoModal').modal('hide');
                        $('#error-alert2').text(data.message);
                        $('#error-alert2').show();
                        $('#loading').css('display', 'flex');
                        $('#content').hide();
                        // location.reload();
                    },
                });
            });

        });
    </script>
@stop