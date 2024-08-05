<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesoria extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'asesorias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'date_create',
        'motivo',
        'estatus',
        'notas',
        'id_estado_nacimiento',
        'link',
        'fecha_cita',
    ];
}
