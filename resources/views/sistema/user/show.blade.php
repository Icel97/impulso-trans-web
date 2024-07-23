@extends('adminlte::page')

@php
    $name = 'Impulso Trans - ' . $usuario->name; 
@endphp
@section('title', $name)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>
            {{ $usuario->name }}
        </h1>
                            
        @can('Crear Usuario')
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newUsuarioModal"><i class="fa fa-plus" aria-hidden="true"></i> Usuario</button>
        @endcan
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
                @if (session('success') == 'Usuario creado')
                    <x-adminlte-alert theme="success" title="Usuario creado" id="success-alert">
                        Usuario creado correctamente.
                    </x-adminlte-alert>
                @elseif (session('success') == 'Usuario eliminado')
                    <x-adminlte-alert theme="success" title="Usuario eliminado" id="success-alert">
                        Usuario eliminado correctamente.
                    </x-adminlte-alert>
                @elseif (session('success') == 'Usuario actualizado')
                    <x-adminlte-alert theme="success" title="Usuario actualizado" id="success-alert">
                        Usuario actualizado correctamente.
                    </x-adminlte-alert>
                @elseif (session('error'))
                    <x-adminlte-alert theme="danger" title="Error" id="error-alert">
                        Error al guardar el Usuario.
                    </x-adminlte-alert>
                @endif

                    {{--  Profile section, show photo, details, payments, current suscription,  --}}
              {{-- Profile section --}}
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ $usuario->profile_photo_url ?? asset('blank-profile-picure-1024x1024.webp') }}" alt="Foto de perfil" class="img-thumbnail">
                    </div>
                    <div class="col-md-9">
                        <h3>{{ $usuario->name }}</h3>
                        <p>Email: {{ $usuario->email }}</p>
                        <p>Rol: 
                            @foreach ($usuario->roles as $rol)
                                <span class="badge badge-info">{{ $rol->name }}</span>
                            @endforeach
                        </p>
                    </div>
                </div>

                {{-- Tabs for Payments and Subscriptions --}}
                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="true">Pagos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="subscriptions-tab" data-toggle="tab" href="#subscriptions" role="tab" aria-controls="subscriptions" aria-selected="false">Suscripciones</a>
                    </li>
                </ul>

                <div class="tab-content" id="profileTabContent">
                    <div class="tab-pane fade show active" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                        {{-- Payments Table --}}
                        <x-adminlte-datatable id="paymentsTable" :heads="['ID', 'Monto', 'Fecha', 'Estatus']">
                            @foreach($usuario->pagos as $pago)
                                <tr>
                                    <td>{{ $pago->id }}</td>
                                    <td>{{ $pago->comprobante_url }}</td>
                                    <td>{{ $pago->validado }}</td>
                                    <td>{{ $pago->created_at }}</td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                    {{-- <div class="tab-pane fade" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
                        <x-adminlte-datatable id="subscriptionsTable" :heads="['ID', 'Fecha Inicio', 'Fecha Fin', 'Estatus']">
                            @foreach($usuario->suscripciones as $suscripcion)
                                <tr>
                                    <td>{{ $suscripcion->id }}</td>
                                    <td>{{ $suscripcion->fecha_inicio }}</td>
                                    <td>{{ $suscripcion->fecha_fin }}</td>
                                    <td>{{ $suscripcion->estatus->value }}</td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div> --}}
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
     @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#newUsuarioModal').modal('show');
            });
        </script>
    @endif
@stop
