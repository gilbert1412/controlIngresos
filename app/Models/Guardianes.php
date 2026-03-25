<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardianes extends Model
{
    protected $table = 'guardianes';

    protected $fillable = [
        'nombre',
        'apePaterno',
        'apeMaterno',
        'estado',
    ];
    
}
