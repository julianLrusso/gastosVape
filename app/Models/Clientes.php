<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Clientes
 *
 * @property int $id
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereDeletedAt($value)
 */
class Clientes extends Model
{
    use SoftDeletes;
    protected $table = "clientes";

    protected $primaryKey = "id";

    protected $fillable = ['nombre', 'direccion', 'telefono'];

    //Reglas de validación
    public static function rules()
    {
        return [
            'nombre' => 'required',
        ];
    }

    public static function rulesMessages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.'
        ];
    }
}
