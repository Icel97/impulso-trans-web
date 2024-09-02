@extends('adminlte::page')

@section('title', 'Impulso trans - Pagos')

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
                <h1>Pagos</h1>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}"
                            href="{{ route('pagos.index', ['filter' => 'all']) }}">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'pending' ? 'active' : '' }}"
                            href="{{ route('pagos.index', ['filter' => 'pending']) }}">Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'review' ? 'active' : '' }}"
                            href="{{ route('pagos.index', ['filter' => 'review']) }}">Por revisar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'approved' ? 'active' : '' }}"
                            href="{{ route('pagos.index', ['filter' => 'approved']) }}">Aprobados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'rejected' ? 'active' : '' }}"
                            href="{{ route('pagos.index', ['filter' => 'rejected']) }}">Rechazados</a>
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
                    <x-adminlte-alert theme="info" title="Info" id="info-alert">
                        {{ session('info') }}
                    </x-adminlte-alert>
                @endif

                {{ session('error ') }}


                @if (sizeof($pagos) > 0)
                    @php
                        $heads = [
                            'ID',
                            'Enviado MM/DD/YY',
                            'Usuario',
                            'Estado',
                            ['label' => 'Acciones', 'no-export' => true, 'width' => 8],
                        ];
                        $config = [
                            'language' => [
                                'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                            ],
                            'order' => [[1, 'desc']],
                            'columns' => [null, null, null, ['orderable' => false], ['orderable' => false]],
                            'lengthMenu' => [25, 50, 100, 500],
                        ];
                    @endphp
                    <x-adminlte-datatable id="table-pagos" :heads="$heads" :config="$config" hoverable compressed>
                        @foreach ($pagos as $pago)
                            @php
                                $status = $pago->validado->value;
                                $turnOffActionValidar = false;
                                $turnOffActionRechazar = false;
                                $rowClass = '';
                                if ($status == 'Aprobado') {
                                    $turnOffActionValidar = true;
                                    $rowClass = 'text-success';
                                } elseif ($status == 'Rechazado') {
                                    $turnOffActionRechazar = true;
                                    $rowClass = 'text-danger';
                                } else {
                                    $rowClass = '';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $pago->id }}</td>
                                <td>{{ $pago->fecha_envio }}</td>
                                <td>{{ $pago->user->email }}</td>
                                <td>{{ $pago->validado }}</td>
                                <td>
                                    @if ($status !== 'Pendiente')
                                        <form action="{{ route('pagos.validarPago') }}" method="post"
                                            class="formValidar d-flex">
                                            <a href="{{ route('pagos.displayPhoto', $pago->id) }}"
                                                class="btn btn-md btn-default text-secondary mx-1" title="Show"
                                                target="_blank">
                                                <i class="fas fa-lg fa-file-image"></i>
                                            </a>
                                            @csrf
                                            <input type="hidden" name="action" id="action-{{ $pago->id }}">
                                            <input type="hidden" name="id" value="{{ $pago->id }}">
                                            @if ($status !== 'Aprobado' && $status !== 'Rechazado' && $status !== 'Expirado')
                                                <button type="submit"
                                                    class="btn btn-md btn-default text-primary mx-1 btn-validate"
                                                    title="Validar" {{ $turnOffActionValidar ? 'disabled' : '' }}>
                                                    <i class="fas fa-lg fa-check"></i>
                                                </button>
                                                <button type="submit"
                                                    class="btn btn-md btn-default text-danger mx-1 btn-reject"
                                                    title="Rechazar" {{ $turnOffActionRechazar ? 'disabled' : '' }}>
                                                    <i class="fas fa-lg fa-times"></i>
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <p>-</p>
                                    @endif
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
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#newProductModal').modal('show');
            });
        </script>
    @endif
@stop
