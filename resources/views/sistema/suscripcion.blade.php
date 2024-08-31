@extends('adminlte::page')

@section('title', 'Impulso trans - Suscripciones')

@section('content_header')
    <h1> </h1>

@stop

@section('content')
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
                <h1>Suscripciones</h1>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}"
                            href="{{ route('suscripciones.index', ['filter' => 'all']) }}">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'inactive' ? 'inactive' : '' }}"
                            href="{{ route('suscripciones.index', ['filter' => 'review']) }}">Inactivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'active' ? 'active' : '' }}"
                            href="{{ route('suscripciones.index', ['filter' => 'active']) }}">Activos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'expired' ? 'expired' : '' }}"
                            href="{{ route('suscripciones.index', ['filter' => 'approved']) }}">Vencidos</a>
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

                @if (sizeof($suscripciones) > 0)
                    @php
                        $heads = [
                            'ID',
                            'Usuario',
                            'Inicio MM/DD/YY',
                            'Fin MM/DD/YY',
                            'Estado',
                            ['label' => 'Acciones', 'no-export' => true, 'width' => 8],
                        ];
                        $config = [
                            'language' => [
                                'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                            ],
                            'order' => [[1, 'desc']],
                            'columns' => [null, null, null, null, ['orderable' => false], ['orderable' => false]],
                            'lengthMenu' => [25, 50, 100, 500],
                        ];
                    @endphp
                    <x-adminlte-datatable id="table-suscripciones" :heads="$heads" :config="$config" hoverable
                        with-buttons compressed>
                        @foreach ($suscripciones as $s)
                            @php
                                $status = $s->estatus->value;
                                $rowClass = '';
                                if ($status == 'Activa') {
                                    $rowClass = 'text-success';
                                } elseif ($status == 'Inactiva') {
                                    $rowClass = 'text-danger';
                                } else {
                                    $rowClass = '';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $s->id }}</td>
                                <td>{{ $s->user->email }}</td>
                                <td>{{ $s->fecha_inicio }}</td>
                                <td>{{ $s->fecha_fin }}</td>
                                <td>
                                    @if ($status == 'Activa')
                                        <span class="badge badge-success">{{ $status }}</span>
                                    @elseif ($status == 'Inactiva')
                                        <span class="badge badge-danger">{{ $status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($status === 'Activa')
                                        <form action="{{ route('suscripciones.actualizarSuscripcion') }}" method="post"
                                            class="formValidar d-flex">
                                            @csrf
                                            <input type="hidden" name="action" id="action-{{ $s->id }}">
                                            <input type="hidden" name="id" value="{{ $s->id }}">
                                            <button type="submit"
                                                class="btn btn-md btn-default text-danger mx-1 btn-reject" title="Rechazar">
                                                <i class="fas fa-lg fa-times"></i>
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex justify-content-center">
                                            <p>-</p>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                @endif
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
                    text: "El pago se marcará como completado.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, rechazar!'
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
                    url: '/productos/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#form-loading').hide();
                        $('#form-content').show();
                        $('#newProductModalLabel').text('Editar Producto');
                        $('#productForm').attr('action', '/productos/' + id);
                        $('#productForm').append('@method('PUT')');
                        $('input[name="nombre"]').val(data.nombre);
                        $('textarea[name="descripcion"]').val(data.descripcion);
                        $('#newProductModal').modal('show');
                    }
                });
            });
        });
    </script>
@stop
