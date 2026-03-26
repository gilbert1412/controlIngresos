<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guardianes;

class Campos extends Model
{
    protected $table = 'campos';

    protected $fillable = [
        'nombre',
        'estado',
        'guardianes_id',
    ];
     public function guardian()
    {
        return $this->belongsTo(Guardianes::class, 'guardianes_id');
    }


}
