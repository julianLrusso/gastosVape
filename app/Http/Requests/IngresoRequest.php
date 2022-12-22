<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'flete' => 'required|numeric',
            'total' => 'required|numeric',
            'descripcion' => 'required',
            'json_productosjson_productos' => 'required|JSON'

        ];
    }

    public function messages()
    {
        return [
            'flete.required' => 'Se necesita valor de flete.',
            'total.required' => 'Se necesita el precio total.',
            'descripcion.required' => 'Se necesita descripción.',
            'json_productos.required' => 'Se necesita al menos un producto.'
        ];
    }
}
