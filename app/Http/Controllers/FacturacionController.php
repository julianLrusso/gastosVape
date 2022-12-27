<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngresoRequest;
use App\Models\Facturas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturacionController extends Controller
{
    /**
     * Muestra la vista del formulario de ingresos
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function ingresos()
    {
        $productos = Productos::all();

        return view('facturacion.ingresos', [
            'productos' => $productos
        ]);
    }

    /**
     * Crea el ingreso
     * @param IngresoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createIngreso(IngresoRequest $request)
    {

        $productos = json_decode($request->json_productos);

        /** @var $factura Facturas */
        $factura = new Facturas();

        $factura->descripcion = $request->descripcion;
        $factura->fk_tipo = $request->tipo;
        $factura->monto_total = $request->total;
        $factura->flete = $request->flete;
        try {
            $factura->save();
            foreach ($productos as $producto){
                $factura->productos()->attach($producto->id,[
                    'cantidad' => $producto->cantidad,
                    'precio' => $producto->precio,
                    'disponible' => $producto->cantidad
                ]);
            }

            DB::commit();
            return redirect()->route('facturacion.ingresos')
                ->with('message.success', 'Factura creada satisfactoriamente.');
        } catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('facturacion.ingresos')
                ->with('message.error', $e);
        }

    }

    public function listadoFacturas(){
        $facturas = Facturas::all();
        return view('facturacion.listadoIngresos', [
            'facturas' => $facturas
        ]);
    }

    public function showIngreso($id){
        $factura = Facturas::find($id);
        return view('facturacion.ingreso', [
            'factura' => $factura
        ]);
    }
}
