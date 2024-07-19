<?php

namespace App\enums;

enum PagoStatusEnum: string
{
    case Pendiente = 'Pendiente';
    case Aprobado = 'Aprobado';
    case Rechazado = 'Rechazado';

    public static function toArray(): array
    {
        return [
            self::Pendiente->value,
            self::Aprobado->value,
            self::Rechazado->value,
        ];
    } 
} 

