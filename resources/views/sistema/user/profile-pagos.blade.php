@if ($usuario->historial_pago->count() == 0)
    <x-adminlte-alert theme="info" title="Alerta" id="info-alert">
        No se encontraron pagos.
    </x-adminlte-alert>
@else
    @php
        $config = [
            'language' => [
                'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            ],
            'order' => [[1, 'desc']],
            'responsive' => true,
            'columns' => [null, null, ['orderable' => false]],
            'lengthMenu' => [10, 25, 50, 100],
        ];
    @endphp

    <x-adminlte-datatable id="paymentsTable" :heads="['ID', 'Fecha envío', 'Acciones', 'estatus']" :config="$config" hoverable compressed>
        @foreach ($usuario->historial_pago as $pago)
            <tr>
                <td>{{ $pago->pago_id }}</td>
                <td>{{ $pago->fecha_envio }}</td>
                <td>
                    <a href="{{ route('pagos.displayPhoto', $pago->pago_id) }}"
                        class="btn btn-md btn-default text-secondary mx-1" title="Show" target="_blank">
                        <i class="fas fa-lg fa-file-image"></i>
                    </a>
                </td>
                <td>{{ $pago->validado }}</td>
            </tr>
        @endforeach

    </x-adminlte-datatable>
@endif
