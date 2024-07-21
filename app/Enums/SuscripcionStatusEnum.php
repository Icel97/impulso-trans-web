<?php

namespace App\enums;

enum SuscripcionStatusEnum: string
{ 
    case Activa = 'Activa'; 
    case Inactiva = 'Inactiva'; 
    case Vencida = 'Vencida'; 

    public static function toArray(): array
    {
        return [
            self::Activa->value,
            self::Inactiva->value,
            self::Vencida->value, 
        ];
    }
}