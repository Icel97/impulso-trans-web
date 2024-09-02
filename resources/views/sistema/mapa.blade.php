@extends('adminlte::page')

@section('title', 'Mapa')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Mapa</h1>
        <button type="button" id="new" class="btn btn-primary" data-toggle="modal" data-target="#newPuntosModal"><i class="fa fa-plus" aria-hidden="true"></i> Punto</button>
    </div>
@stop

@section('content')
    <div id="loading" style="display: none;" class="justify-content-center align-self-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="200" height="200" style="shape-rendering: auto; display: block; background: rgb(255, 255, 255);" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle stroke-width="8" stroke="#f5a9b8" fill="none" r="0" cy="50" cx="50">
            <animate begin="0s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1" values="0;57" dur="1.5625s" repeatCount="indefinite" attributeName="r"></animate>
            <animate begin="0s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1" values="1;0" dur="1.5625s" repeatCount="indefinite" attributeName="opacity"></animate>
            </circle><circle stroke-width="8" stroke="#5bcefa" fill="none" r="0" cy="50" cx="50">
            <animate begin="-0.78125s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1" values="0;57" dur="1.5625s" repeatCount="indefinite" attributeName="r"></animate>
            <animate begin="-0.78125s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1" values="1;0" dur="1.5625s" repeatCount="indefinite" attributeName="opacity"></animate>
            </circle><g></g></g><!-- [ldio] generated by https://loading.io -->
        </svg>
    </div>

    <div id="content">
        <div class="card">
            <div class="card-body">
                @if (session('success') == 'Punto guardado')
                    <x-adminlte-alert theme="success" title="Punto guardado" id="success-alert">
                        Punto guardado correctamente.
                    </x-adminlte-alert>
                @elseif (session('success') == 'Punto eliminado')
                    <x-adminlte-alert theme="success" title="Punto eliminado" id="success-alert">
                    Punto eliminado correctamente.
                    </x-adminlte-alert>
                @elseif (session('success') == 'Punto actualizado')
                    <x-adminlte-alert theme="success" title="Punto actualizado" id="success-alert">
                        Punto actualizado correctamente.
                    </x-adminlte-alert>
                @elseif (session('error'))
                    <x-adminlte-alert theme="danger" title="Error" id="error-alert">
                        Error al guardar el Punto.
                    </x-adminlte-alert>
                @endif

                @php
                    $heads = [
                        'ID',
                        'Estado',
                        'Latitud',
                        'Longitud',
                        'Documentos',
                        ['label' => 'Actions', 'no-export' => true, 'width' => 15]
                    ];

                    $btnEdit = '';
                    $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>';
                    
                    $config = [
                        'language'=> [
                            'url' => '/js/lang/es-ES.json'
                        ]
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                    @foreach($points as $punto)
                        <tr>
                            <td>{{ $punto->id }}</td>
                            <td>{{ $punto->estado }}</td>
                            <td>{{ $punto->lat }}</td>
                            <td>{{ $punto->lng }}</td>
                            <td>
                                <ul>
                                @foreach(explode(',', $punto->documentos) as $documento)
                                    <li>{{ trim($documento) }}</li>
                                @endforeach
                                </ul>
                            </td>                            <td>
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow edit-button" data-id="{{ $punto->id }}" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                                
                                <form style="display: inline" action="{{ route('puntos.destroy', $punto->id) }}" method="post" class="formEliminar">
                                    @csrf
                                    @method('DELETE')
                                    {!! $btnDelete !!}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>

            </div>
        </div>

        <div class="modal fade" id="newPuntosModal" tabindex="-1" role="dialog" aria-labelledby="newPuntosModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newPuntosModalLabel">Nuevo Puntos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="form-loading" style="display: none;" class="justify-content-center align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="200" height="200" style="shape-rendering: auto; display: block; background: rgb(255, 255, 255);" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle stroke-width="8" stroke="#f5a9b8" fill="none" r="0" cy="50" cx="50">
                                <animate begin="0s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1" values="0;57" dur="1.5625s" repeatCount="indefinite" attributeName="r"></animate>
                                <animate begin="0s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1" values="1;0" dur="1.5625s" repeatCount="indefinite" attributeName="opacity"></animate>
                                </circle><circle stroke-width="8" stroke="#5bcefa" fill="none" r="0" cy="50" cx="50">
                                <animate begin="-0.78125s" calcMode="spline" keySplines="0 0.2 0.8 1" keyTimes="0;1" values="0;57" dur="1.5625s" repeatCount="indefinite" attributeName="r"></animate>
                                <animate begin="-0.78125s" calcMode="spline" keySplines="0.2 0 0.8 1" keyTimes="0;1" values="1;0" dur="1.5625s" repeatCount="indefinite" attributeName="opacity"></animate>
                                </circle><g></g></g><!-- [ldio] generated by https://loading.io -->
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
                            <form id="puntoForm" action="{{ route('puntos.store') }}" method="post">
                                @csrf
                                <x-adminlte-input type="text" name="estado" label="Estado" placeholder="Queretaro" label-class="text-lightblue" value="{{ old('estado') }}">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-cube text-lightblue"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                                <x-adminlte-input type="text" name="lat" label="Latitud" placeholder="20.588144" label-class="text-lightblue" value="{{ old('lat') }}">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-cube text-lightblue"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                                <x-adminlte-input type="text" name="lng" label="Longitud" placeholder="-100.387922" label-class="text-lightblue" value="{{ old('lng') }}">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-cube text-lightblue"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                                <x-adminlte-textarea name="documentos" label="Documentos" rows=5 igroup-size="sm"
                                    label-class="text-primary" placeholder="Acta de nacimiento, Identificación oficial, Comprobante de domicilio" disable-feedback>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-lg fa-file-alt text-primary"></i>
                                        </div>
                                    </x-slot>
                                    {{ old('documentos') }}
                                </x-adminlte-textarea>
                                <div class="modal-footer">
                                    <x-adminlte-button label="Cerrar" theme="secondary" icon="fas fa-times" data-dismiss="modal"/>
                                    <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="fas fa-save"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
    // Inicializar cuando la página esté completamente cargada
    $('#loading').css('display', 'flex');
    $('#content').hide();
    $(window).on('load', function() {
        $('#loading').hide();
        $('#content').show();
    });

    @if ($errors->any())
        $('#newPuntosModal').modal('show');
    @endif

    // Hide alerts after 5 seconds
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 5000);

    // Limpiar el formulario cuando se abre el modal de "Nuevo Punto"
    $('#new').click(function () {
        $('#newPuntosModalLabel').text('Nuevo Punto');
        $('#puntoForm').attr('action', '{{ route('puntos.store') }}');
        $('#puntoForm').trigger('reset'); // Limpiar el formulario
        $('#puntoForm').find('input[name="_method"]').remove(); // Asegúrate de eliminar cualquier input hidden de método
    });

    // Cargar los datos para la edición
    $('.edit-button').click(function() {
        var id = $(this).data('id');
        $('#form-loading').css('display', 'flex');
        $('#form-content').hide();
        
        $.ajax({
            url: '/puntos/' + id + '/edit',
            method: 'GET',
            dataType: 'json', // Asegúrate de recibir los datos como JSON
            success: function(data) {
                $('#form-loading').hide();
                $('#form-content').show();
                $('#newPuntosModalLabel').text('Editar Punto');
                
                // Actualizar el formulario con los datos recibidos
                $('#puntoForm').attr('action', '/puntos/' + id);
                $('#puntoForm').find('input[name="_method"]').remove(); // Eliminar cualquier input hidden de método
                $('#puntoForm').append('<input type="hidden" name="_method" value="PUT">');

                // Rellenar los valores en el formulario
                $('input[name="estado"]').val(data.estado);
                $('input[name="lat"]').val(data.lat);
                $('input[name="lng"]').val(data.lng);
                $('textarea[name="documentos"]').val(data.documentos);

                // Mostrar el modal de edición
                $('#newPuntosModal').modal('show');
            },
            error: function(xhr, status, error) {
                $('#form-loading').hide();
                $('#form-content').show();
                alert('Error al cargar los datos del punto de interés: ' + error);
            }
        });
    });

    // Confirmación de eliminación
    $('.formEliminar').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, bórralo!'
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

    // Mostrar el loading al enviar el formulario
    $('#puntoForm').submit(function() {
        $('#form-loading').css('display', 'flex');
        $('#form-content').hide();
    });
});

    </script>
@stop
