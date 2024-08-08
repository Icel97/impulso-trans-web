<?php

namespace App\Enums;

enum AsesoriasMotivoEnum: string
{
    case DISCRIMINACION = 'Discriminación';
    case ACTUALIZAR = 'Actualización';
    case GESTORIA = 'Gestoría';
    case OTRO = 'Otro';

    public static function toArray(): array
    {
        return [
            self::DISCRIMINACION->value,
            self::ACTUALIZAR->value,
            self::GESTORIA->value,
            self::OTRO->value,
        ];
    }
}
