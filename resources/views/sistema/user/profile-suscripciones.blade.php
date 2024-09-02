@if ($usuario->historial_suscripcion->count() == 0)
    <x-adminlte-alert theme="info" title="Alerta" id="info-alert">
        No se encontraron suscripciones.
    </x-adminlte-alert>
@else
    @php
        $config = [
            'language' => [
                'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            ],
            'order' => [[1, 'desc']],
            'columns' => [null, null, ['orderable' => false]],
            'lengthMenu' => [10, 25, 50, 100],
        ];
    @endphp

    <x-adminlte-datatable id="subscriptionsTable" :heads="['ID', 'Fecha Inicio', 'Fecha Fin', 'Estatus']" :config="$config" hoverable compressed>
        @foreach ($usuario->historial_suscripcion as $suscripcion)
            <tr>
                <td>{{ $suscripcion->suscripcion_id }}</td>
                <td>{{ $suscripcion->fecha_inicio }}</td>
                <td>{{ $suscripcion->fecha_fin }}</td>
                <td>{{ $suscripcion->estatus }}</td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@endif
