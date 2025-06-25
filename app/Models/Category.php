<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name'];

    // Relación: Una categoría tiene muchas comidas
    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}
