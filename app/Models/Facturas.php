<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $descripcion
 * @property float $monto_total
 * @property float $flete
 * @property int $fk_cliente
 * @property int $fk_tipo
 */
class Facturas extends Model
{
    use SoftDeletes;
    protected $table = "gastos";

    protected $fillable = ['descripcion', 'monto_total', 'flete', 'fk_cliente', 'fk_tipo'];

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
        )->withPivot('cantidad', 'precio', 'disponible');
    }
}
