<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'guest', 
        'date', 
        'time', 
        'message', 
        'table_id',
    ];
    

    // Relación con la tabla `tables`
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
