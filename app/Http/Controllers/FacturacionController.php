<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngresoRequest;
use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FacturacionController extends Controller
{
    public function home(){

        $facturas = Facturas::all();

        return view('home', [
            'facturas' => $facturas
        ]);
    }

    /**
     * Home pero con las facturas filtradas por fechas
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function homeFiltrado(Request $request) {
        if ($request->firstDate && $request->lastDate){
            $startDate = Carbon::createFromFormat('Y-m-d', $request->firstDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->lastDate)->endOfDay();
            $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $facturas = Facturas::all();
        }
        return view('home', [
            'facturas' => $facturas
        ])->with('message.error', 'Error al filtrar.');

    }

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
     * Muestra la vista del formulario de ventas
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function ventas()
    {
        $productos = Productos::all();
        $clientes = Clientes::all();

        return view('facturacion.ventas', [
            'productos' => $productos,
            'clientes' => $clientes
        ]);
    }

    /**
     * Crea el ingreso
     * @param IngresoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createIngreso(IngresoRequest $request)
    {
        DB::beginTransaction();
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
                    'precio' => $producto->precioUnitario,
                    'disponible' => $producto->cantidad
                ]);
                $prodEnDb = Productos::find($producto->id);
                $prodEnDb->stock = $prodEnDb->stock + $producto->cantidad;
                $prodEnDb->save();
            }

            DB::commit();
            return redirect()->route('facturacion.listado')
                ->with('message.success', 'Factura creada satisfactoriamente.');
        } catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('facturacion.listado')
                ->with('message.error', $e->getMessage());
        }

    }

    /**
     * Crea la venta en la base de datos.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createVenta(Request $request){

        DB::beginTransaction();
        $productos = json_decode($request->json_productos);

        /** @var Facturas $factura */
        $factura = new Facturas();

        $factura->descripcion = $request->descripcion;
        $factura->fk_tipo = $request->tipo;
        $factura->monto_total = $request->total;
        $factura->fk_cliente = $request->cliente;
        $factura->flete = 0;

        try {
            $factura->save();
            foreach ($productos as $producto){

                $facturaAntigua = Facturas::find($producto->factura);
                $facturaAntigua->productos()->updateExistingPivot($producto->id,[
                    'disponible' => $producto->disponible - $producto->cantidad
                ]);

                $factura->productos()->attach($producto->id,[
                    'cantidad' => $producto->cantidad,
                    'precio' => $producto->precio,
                    'disponible' => 0
                ]);

                $prodEnDb = Productos::find($producto->id);
                $prodEnDb->stock = $prodEnDb->stock - $producto->cantidad;
                $prodEnDb->save();
            }

            DB::commit();
            return redirect()->route('facturacion.listado')
                ->with('message.success', 'Factura creada satisfactoriamente.');
        } catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('facturacion.listado')
                ->with('message.error', $e->getMessage());
        }
    }

    /**
     * Muestra un listado de facturas
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listadoFacturas(){
        $facturas = Facturas::orderBy('id','desc')->get();
        return view('facturacion.listadoIngresos', [
            'facturas' => $facturas
        ]);
    }

    /**
     * Muestra un listado de facturas pero filtradas por fecha o tipo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listadoFacturasFiltrado(Request $request){
        if ($request->firstDate && $request->lastDate) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->firstDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->lastDate)->endOfDay();
            if ($request->factura_tipo){
                $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])->where('fk_tipo', $request->factura_tipo)->orderBy('id','desc')->get();
            } else {
                $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])->orderBy('id','desc')->get();
            }

        } elseif ($request->factura_tipo) {
            $facturas = Facturas::where('fk_tipo', $request->factura_tipo)->orderBy('id','desc')->get();
        } else {
            $facturas = Facturas::orderBy('id','desc')->get();
        }

        return view('facturacion.listadoIngresos', [
            'facturas' => $facturas
        ]);
    }

    /**
     * Muestra el detalle del ingreso
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showIngreso($id){
        $factura = Facturas::find($id);
        return view('facturacion.ingreso', [
            'factura' => $factura
        ]);
    }
}
