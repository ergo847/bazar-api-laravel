<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'url',
    ];
}
