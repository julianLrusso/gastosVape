<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Productos
 *
 * @property int $id
 * @property string $nombre
 * @property int $stock
 * @property int $peso
 * @property float $precio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Productos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Productos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Productos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Productos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Productos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Productos whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Productos whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Productos wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Productos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Productos whereDeletedAt($value)
 */
class Productos extends Model
{
    use SoftDeletes;
    protected $table = "productos";

    protected $primaryKey = "id";

    protected $fillable = ['nombre', 'stock', 'peso', 'precio'];

    //Reglas de validación
    public static function rules()
    {
        return [
            'nombre' => 'required',
//            'precio'  => 'required',
            'peso'   => 'required'
        ];
    }

    public static function rulesMessages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
//            'precio.required'  => 'El stock es obligatorio.',
            'peso.required'   => 'El peso es obligatorio.'
        ];
    }

    public function facturas()
    {
        return $this->belongsToMany(
            Facturas::class,
            'gastos_tienen_productos',
            'fk_producto',
            'fk_factura'
        )->withPivot('cantidad', 'precio', 'disponible');
    }
}
