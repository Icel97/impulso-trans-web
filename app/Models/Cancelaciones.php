<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelaciones extends Model
{
    use HasFactory;

    protected $table = 'cancelaciones';
    protected $primaryKey = 'id';
    //timestamps false
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
