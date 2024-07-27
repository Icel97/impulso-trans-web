<?php

namespace App\enums;

enum PagoStatusEnum: string
{
    case Pendiente = 'Pendiente';
    case Revision = 'Revision'; 
    case Aprobado = 'Aprobado';
    case Rechazado = 'Rechazado';
    case Expirado = 'Expirado'; 

    public static function toArray(): array
    {
        return [

            self::Pendiente->value,
            self::Revision->value,
            self::Aprobado->value,
            self::Rechazado->value,
            self::Expirado->value,
        ];
    } 
} 

