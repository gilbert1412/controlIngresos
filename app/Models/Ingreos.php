<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreos extends Model
{
    protected $fillable=[
         'numRecibo',
        'fechaIngreso',
        'campos_id',
        'guardianes_id',
        'monto'
    ];
    protected $table='ingresos';
}
