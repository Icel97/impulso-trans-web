<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'historial__suscripcions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'suscripcion_id',
        'estatus',
        'fecha_inicio',
        'fecha_fin',
        'usuario_id',
        'created_at',
        'updated_at',
    ];

    public function suscripcion()
    {
        return $this->belongsTo(Suscripcion::class, 'suscripcion_id', 'id');
    }
}
