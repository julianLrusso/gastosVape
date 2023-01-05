<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFactura extends Model
{
    protected $table = "tipo_gasto";
    protected $fillable = ['tipo'];
}
