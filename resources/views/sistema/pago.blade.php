@extends('adminlte::page')

@section('title', 'Impulso trans - Pagos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Pagos</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newProductModal">Nuevo Producto</button>
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
            <div class="card-title">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}" href="{{ route('pagos.index', ['filter' => 'all']) }}">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'pending' ? 'active' : '' }}" href="{{ route('pagos.index', ['filter' => 'pending']) }}">Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'approved' ? 'active' : '' }}" href="{{ route('pagos.index', ['filter' => 'approved']) }}">Aprobados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'rejected' ? 'active' : '' }}" href="{{ route('pagos.index', ['filter' => 'rejected']) }}">Rechazados</a>
                    </li>
                </ul>
            </div>    
            <div class="card-body">
                @if (session('success') == 'Pago validado')
                    <x-adminlte-alert theme="success" title="Producto guardado" id="success-alert">
                        Estado del pago actualizado correctamente. 
                    </x-adminlte-alert>
                @elseif (session('success') == 'Pago rechazado')
                    <x-adminlte-alert theme="success" title="Estado de pago actualizado" id="success-alert">
                        Estado del pago actualizado correctamente. 
                    </x-adminlte-alert>
                @elseif (session('error'))
                    <x-adminlte-alert theme="danger" title="Error" id="error-alert">
                        Hubo un error al actualizar el estatus del pago. 
                    </x-adminlte-alert>
                @endif

                @php
                    $heads = [
                        'ID',
                        'Enviado MM/DD/YY',
                        'Usuario', 
                        "Estado", 
                        ['label' => 'Acciones','no-export' => true, 'width' => 8], 
                    ];

                    $btnEdit = '';
                    $btnValidate = '<button type="submit" class="btn btn-md btn-default text-primary mx-1 btn-validate" title="Validar">
                                        <i class="fas fa-lg fa-check"></i>
                                    </button>';
                    $btnReject = '<button type="submit" class="btn btn-md btn-default text-danger mx-1 btn-reject" title="Rechazar">
                                        <i class="fas fa-lg fa-times"></i>
                                    </button>'; 
                    
                    $config = [
                        'language'=> [
                            'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                                ],
                                'order' => [[1, 'desc']],
                        "columns" => [null, null, null, ['orderable' => false], ['orderable' => false]],
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                    @foreach($pagos as $pago)
                    @php 
                    $status = $pago->validado->value;
                    $turnOffActionValidar = false;
                    $turnOffActionRechazar = false;
                        $rowClass = '';
                        if($status == 'Aprobado'){
                            $turnOffActionValidar = true;
                            $rowClass = 'table-dark text-success';
                        }
                        else if($status == 'Rechazado'){
                            $turnOffActionRechazar = true; 
                            $rowClass = 'table-dark text-danger';
                        }
                        else{ 
                            $rowClass = ''; 
                        }
                    @endphp
                        <tr class="{{ $rowClass }}">
                            <td>{{ $pago->id }}</td>
                            <td>{{ $pago->created_at}}</td>
                            <td>{{ $pago->user->email }}</td> 
                            <td>{{ $pago->validado }}</td> 
                            <td>
                                    <form  action="{{ route('pagos.validarPago') }}" method="post" class="formValidar d-flex">
                                    <a href="{{ route('pagos.displayPhoto', $pago->id) }}" class="btn btn-md btn-default text-secondary mx-1" title="Show" target="_blank">
                                        <i class="fas fa-lg fa-file-image"></i>
                                    </a>
                                        @csrf
                                        <input type="hidden" name="action" id="action-{{ $pago->id }}">
                                        <input type="hidden" name="id" value="{{ $pago->id }}">
                                        @if(!$pago->validado->value == 'Aprobado' && !$pago->validado->value == 'Rechazado')
                                        <button type="submit" class="btn btn-md btn-default text-primary mx-1 btn-validate" title="Validar"
                                        {{ $turnOffActionValidar ? 'disabled' : '' }}
                                        >
                                            <i class="fas fa-lg fa-check"></i>
                                        </button>
                                        <button type="submit" class="btn btn-md btn-default text-danger mx-1 btn-reject" title="Rechazar"
                                        {{ $turnOffActionRechazar ? 'disabled' : '' }}
                                        
                                        >
                                            <i class="fas fa-lg fa-times"></i>
                                        </button> 
                                        @endif
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>

            </div>
        </div>

        <div class="modal fade" id="newProductModal" tabindex="-1" role="dialog" aria-labelledby="newProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newProductModalLabel">Nuevo Pago</h5>
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
                            <form id="productForm" action="{{ route('productos.store') }}" method="post">
                                @csrf
                                <x-adminlte-input type="text" name="nombre" label="Nombre" placeholder="nuevo producto" label-class="text-lightblue" value="{{ old('nombre') }}">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-cube text-lightblue"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                                <x-adminlte-textarea name="descripcion" label="Descripcion" rows=5 igroup-size="sm"
                                    label-class="text-primary" placeholder="ejemplo ..." disable-feedback>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-lg fa-file-alt text-primary"></i>
                                        </div>
                                    </x-slot>
                                    {{ old('descripcion') }}
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
            }, 5000);

            $('.formValidar').submit(function(e) {
        e.preventDefault();
        var action = '';
        var formId = $(this).find('input[name="action"]').attr('id');
        
        if ($(this).find('.btn-validate').is(':focus')) {
            action = 'accepted';
        } else if ($(this).find('.btn-reject').is(':focus')) {
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

            $('#productForm').submit(function() {
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
            });

            $('.edit-button').click(function() {
                var id = $(this).data   ('id');
                $('#form-loading').css('display', 'flex');
                $('#form-content').hide();
                $.ajax({
                    url: '/productos/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#form-loading').hide();
                        $('#form-content').show();
                        $('#newProductModalLabel').text('Editar Producto');
                        $('#productForm').attr('action', '/productos/' + id);
                        $('#productForm').append('@method("PUT")');
                        $('input[name="nombre"]').val(data.nombre);
                        $('textarea[name="descripcion"]').val(data.descripcion);
                        $('#newProductModal').modal('show');
                    }
                });
            });
        });
    </script>
@stop
