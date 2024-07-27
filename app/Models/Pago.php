<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PagoStatusEnum; 

class Pago extends Model
{
    
    use HasFactory;

    protected $table = 'pagos'; 
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'comprobante_url',
        'validado',
        'usuario_id',    
        'fecha_envio',
        'created_at', 
        'updated_at',	   
    ];

    protected $hidden = [
        "usuario_id", 
    ];

    protected $casts = [
        'validado' => PagoStatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    } 
    public function history_payments()
    {
        return $this->hasMany(Historial_Pago::class, 'pago_id', 'id');
    }
}
