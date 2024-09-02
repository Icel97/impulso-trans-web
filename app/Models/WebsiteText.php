<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteText extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'title',
        'content',
        'url_img',
    ];
}
