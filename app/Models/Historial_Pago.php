<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos_historial';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pago_id',
        'comprobante_url',
        'validado',
        'fecha_envio',
        'usuario_id',
        'created_at',
        'updated_at',
    ];


    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id', 'id');
    }
}
