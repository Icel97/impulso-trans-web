<?php

namespace App\Enums;

enum AsesoriasStatusEnum: string
{
    case PENDIENTE = 'Pendiente';
    case CANCELADA = 'Cancelada';
    case FINALIZADA = 'Finalizada';

    public static function toArray(): array
    {
        return [
            self::PENDIENTE->value,
            self::CANCELADA->value,
            self::FINALIZADA->value,
        ];
    }
}
