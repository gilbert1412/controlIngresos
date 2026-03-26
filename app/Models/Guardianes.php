<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campos;
class Guardianes extends Model
{
    protected $table = 'guardianes';

    protected $fillable = [
        'nombre',
        'apePaterno',
        'apeMaterno',
        'estado',
    ];

     public function campos()
    {
        return $this->hasMany(Campos::class, 'guardianes_id');
    }

}
