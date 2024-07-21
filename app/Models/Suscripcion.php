<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SuscripcionStatusEnum; 

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = "suscripciones"; 
    protected $primaryKey = "id"; 

    protected $fillable = [
        "estatus", 
        "fecha_inicio",
        "fecha_fin", 
        "usuario_id",
    ];

    protected $casts = [
        'estatus' => SuscripcionStatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    } 

}
