@extends('adminlte::page')

@section('title', 'Impulso trans - Asesorías')

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
                        <a class="nav-link {{ $filter === 'pendientes' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'pendientes']) }}">Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'finalizadas' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'finalizadas']) }}">Finalizada</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'canceladas' ? 'active' : '' }}"
                            href="{{ route('asesorias.index', ['filter' => 'canceladas']) }}">Canceladas</a>
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
                                <td> {{ $asesoria->fecha_cita }} </td>
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
                    <div id="form-content">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="asesoriasForm" action="{{ route('asesorias.actualizar') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id') }}" id="asesoria-id">

                            <x-adminlte-input name="identidad_genero" label="Identidad de Género"
                                placeholder="Identidad de Género" label-class="text-lightblue"
                                value="{{ old('identidad_genero') }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-cube text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-input name="pronombres" label="Pronombre" placeholder="Pronombre"
                                label-class="text-lightblue" value="{{ old('pronombres') }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-cube text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-select name="estatus" label="Estatus" label-class="text-lightblue">
                                @foreach ($estatus as $estado)
                                    <option value="{{ $estado }}"
                                        {{ old('estatus') == $estado ? 'selected' : '' }}>
                                        {{ $estado }}</option>
                                @endforeach
                            </x-adminlte-select>

                            <x-adminlte-input name="motivo" label="Motivo" placeholder="Motivo"
                                label-class="text-lightblue" value="{{ old('motivo') }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-cube text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-input name="canceladas" label="Cancelaciones (consecutivas)"
                                placeholder="Cancelaciones consecutivas" label-class="text-lightblue"
                                value="{{ old('canceladas') }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-cube text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-textarea name="notas" label="Notas" placeholder="Notas"
                                label-class="text-lightblue" rows=3>
                                {{ old('notas') }}
                            </x-adminlte-textarea>

                            <div class="modal-footer">
                                <x-adminlte-button label="Cerrar" theme="secondary" icon="fas fa-times"
                                    data-dismiss="modal" />
                                <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-save" />
                            </div>
                        </form>
                    </div>
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

            $('#asesoriasForm').submit(function() {
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
            });

            // Handle the click event for the details button
            $('body').on('click', '.btn-info', function() {
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
                $('#infoModal').find('.alert-danger').remove(); // Remove error alert
                // Reset the form
                $('#infoModal').find('form')[0].reset();
                $('#infoModal').find('.is-invalid').removeClass('is-invalid');
                $('#infoModal').find('.invalid-feedback').remove();


                var id = $(this).data('id');
                $.ajax({
                    url: '/api/asesorias/' + id,
                    method: 'GET',
                    success: function(data) {
                        // Populate the fields with the fetched data
                        $('#asesoria-id').val(data.id);
                        $('input[name="identidad_genero"]').val(data.user.identidad_genero ??
                            '-');
                        $('input[name="pronombres"]').val(data.user.pronombres ?? '-');
                        $('input[name="motivo"]').val(data.motivo ?? '-');
                        $('input[name="canceladas"]').val(data.user.cancelacion.total ?? '-');
                        $('select[name="estatus"]').val(data.estatus);
                        $('textarea[name="notas"]').val(data.notas ?? '-');

                        // Enable the modal content and hide the loading animation
                        $('#form-loading').hide();
                        $('#asesoriaForm').show();
                    },
                    error: function() {
                        console.error("Error fetching data for Asesoría ID: " + id);
                    },
                    complete: function() {
                        $('#form-loading').hide();
                        $('#form-content').show();
                    }
                });
            });
        });
    </script>
    @if ($errors->any())
        <script>
            console.log("Modal will open for Asesoria ID -> {{ session('asesoria_id') }}");
            var asesoriaId = "{{ session('asesoria_id') }}";

            // Check if button exists
            if ($('button[data-id="' + asesoriaId + '"]').length > 0) {
                console.log("Button found for asesoria ID: " + asesoriaId);
                // Open modal for the row with the ID
                $('button[data-id="' + asesoriaId + '"]').click();
            } else {
                console.error("Button not found for asesoria ID: " + asesoriaId);
            }
        </script>
    @endif

@stop
