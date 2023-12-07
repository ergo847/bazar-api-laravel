<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'brand',
        'category',
        'thumbnail',
        'price',
        'discountPercentage',
        'rating',
        'stock',
    ];

    public function images()
    {
        return $this->hasMany(ImageProducto::class);
    }

    public function detalle()
    {
        $images = $this->images()->get()->pluck('url')->toArray();
        $this->images = $images;
        return $this;
    }
}
