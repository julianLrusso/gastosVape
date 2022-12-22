<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngresoRequest;
use App\Models\Productos;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function ingresos(){
        $productos = Productos::all();

        return view('facturacion.ingresos', [
            'productos' => $productos
        ]);
    }

    public function createIngreso(IngresoRequest $request){

    }
}
