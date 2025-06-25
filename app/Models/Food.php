<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food';

    protected $fillable = [
        'title',
        'price',
        'image',
        'description',
        'ingredients',
        'proteins',
        'calories',
        'size',
        'category_id' // Nueva columna para la relación
    ];

    // Relación: Una comida pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
