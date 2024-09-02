<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'lat',
        'lng',
        'documentos',
    ];

    protected $table = 'points_of_interest';
}
