<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoFactura extends Model
{
    use SoftDeletes;
    protected $table = "tipo_gasto";

    protected $fillable = ['tipo'];
}
