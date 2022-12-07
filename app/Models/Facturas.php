<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facturas extends Model
{
    use SoftDeletes;
    protected $table = "gastos";

    protected $fillable = ['monto', 'monto_total', 'flete', 'fk_cliente', 'fk_tipo'];

    public function tipo()
    {
        return $this->belongsTo(TipoFactura::class, 'fk_tipo');
    }

    public function productos()
    {
        return $this->belongsToMany(
            Productos::class,
            'gastos_tienen_productos',
            'fk_factura',
            'fk_producto'
        );
    }
}
