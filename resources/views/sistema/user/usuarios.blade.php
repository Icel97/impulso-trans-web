@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Usuarios</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newUsuarioModal"><i class="fa fa-plus" aria-hidden="true"></i> Usuario</button>
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
                @if (session('success') == 'Usuario guardado')
                    <x-adminlte-alert theme="success" title="Usuario guardado" id="success-alert">
                        Usuario guardado correctamente.
                    </x-adminlte-alert>
                @elseif (session('success') == 'Producto eliminado')
                    <x-adminlte-alert theme="success" title="Producto eliminado" id="success-alert">
                        Producto eliminado correctamente.
                    </x-adminlte-alert>
                @elseif (session('success') == 'Usuario actualizado')
                    <x-adminlte-alert theme="success" title="Usuario actualizado" id="success-alert">
                        Usuario actualizado correctamente.
                    </x-adminlte-alert>
                @elseif (session('error'))
                    <x-adminlte-alert theme="danger" title="Error" id="error-alert">
                        Error al guardar el producto.
                    </x-adminlte-alert>
                @endif

                @php
                    $heads = [
                        'ID',
                        'Nombre',
                        ['label' => 'Actions', 'no-export' => true, 'width' => 15],
                    ];

                    $btnEdit = '';
                    $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>';
                    
                    $config = [
                        'language'=> [
                            'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                        ]
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>
                                <!-- editar nombre -->
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow edit-button" data-id="{{ $usuario->id }}" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                                <!-- asignar permisos -->
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-xs btn-default text-success mx-1 shadow" title="Permisos">
                                    <i class="fa fa-lg fa-fw fa-key"></i>
                                </a>
                                <!-- eliminar Usuario -->
                                <form style="display: inline" action="{{ route('usuarios.destroy', $usuario->id) }}" method="post" class="formEliminar">
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

        <div class="modal fade" id="newUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="newUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newUsuarioModalLabel">Nuevo Usuario</h5>
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
                            <form id="productForm" action="{{ route('usuarios.store') }}" method="post">
                                @csrf
                                <x-adminlte-input type="text" name="nombre" label="Nombre" placeholder="nuevo Usuario" label-class="text-lightblue" value="{{ old('nombre') }}">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-cube text-lightblue"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
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
            $('#loading').css('display', 'flex');
            $('#content').hide();
            $(window).on('load', function() {
                $('#loading').hide();
                $('#content').show();
            });

            @if ($errors->any())
                $('#newUsuarioModal').modal('show');
            @endif

            // Hide alerts after 5 seconds
            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
                $('#error-alert').fadeOut('slow');
            }, 5000);

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

            $('#productForm').submit(function() {
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
            });

            $('.edit-button').click(function() {
                var id = $(this).data('id');
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
                $.ajax({
                    url: '/usuarios/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#form-loading').hide();
                        $('#form-content').show();
                        $('#newUsuarioModalLabel').text('Editar Usuario');
                        $('#productForm').attr('action', '/usuarios/' + id);
                        $('#productForm').append('@method("PUT")');
                        $('input[name="nombre"]').val(data.name);
                        $('#newUsuarioModal').modal('show');
                    }
                });
            });
        });
    </script>
@stop
