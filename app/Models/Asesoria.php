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
        'motivo',
        'estatus',
        'notas',
        'id_estado_nacimiento',
        'link',
        'fecha_cita',
        'canceladas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
