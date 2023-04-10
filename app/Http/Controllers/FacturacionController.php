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
    public function home()
    {

        $facturas = Facturas::orderBy('id', 'desc')->paginate(25);

        return view('home', [
            'facturas' => $facturas
        ]);
    }

    /**
     * Home pero con las facturas filtradas por fechas
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function homeFiltrado(Request $request)
    {
        if ($request->firstDate && $request->lastDate) {
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
            'clientes'  => $clientes
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
            foreach ($productos as $producto) {
                $factura->productos()->attach($producto->id, [
                    'cantidad'   => $producto->cantidad,
                    'precio'     => $producto->precioUnitario,
                    'disponible' => $producto->cantidad
                ]);
                $prodEnDb = Productos::find($producto->id);
                $prodEnDb->stock = $prodEnDb->stock + $producto->cantidad;
                $prodEnDb->save();
            }

            DB::commit();
            return redirect()->route('facturacion.listado')
                ->with('message.success', 'Factura creada satisfactoriamente.');
        } catch (\Exception $e) {
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
    public function createVenta(Request $request)
    {

        DB::beginTransaction();
        $productos = json_decode($request->json_productos);

        /** @var Facturas $factura */
        $factura = new Facturas();

        $factura->descripcion = $request->descripcion;
        $factura->fk_tipo = $request->tipo;
        $factura->monto_total = $request->total;
        $factura->fk_cliente = $request->cliente;
        $factura->utilidadTotal = $request->utilidadTotal;
        $factura->flete = 0;

        try {
            $factura->save();
            foreach ($productos as $producto) {

                $facturaAntigua = Facturas::find($producto->factura);
                $facturaAntigua->productos()->updateExistingPivot($producto->id, [
                    'disponible' => $producto->disponible - $producto->cantidad
                ]);

                $factura->productos()->attach($producto->id, [
                    'cantidad'   => $producto->cantidad,
                    'precio'     => $producto->precio,
                    'disponible' => 0,
                    'utilidad'   => $producto->utilidad
                ]);

                $prodEnDb = Productos::find($producto->id);
                $prodEnDb->stock = $prodEnDb->stock - $producto->cantidad;
                $prodEnDb->save();
            }

            DB::commit();
            return redirect()->route('facturacion.listado')
                ->with('message.success', 'Factura creada satisfactoriamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('facturacion.listado')
                ->with('message.error', $e->getMessage());
        }
    }

    /**
     * Muestra un listado de facturas
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listadoFacturas()
    {
//        $facturas = Facturas::orderBy('id','desc')->get();
        $clientes = Clientes::all();
        return view('facturacion.listadoIngresos', [
            'clientes' => $clientes
        ]);
    }

    /**
     * Muestra un listado de facturas pero filtradas por fecha o tipo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listadoFacturasFiltrado(Request $request)
    {
        if ($request->firstDate && $request->lastDate) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->firstDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->lastDate)->endOfDay();
            if ($request->factura_tipo && $request->cliente) {
                $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])
                    ->where('fk_tipo', $request->factura_tipo)
                    ->where('fk_cliente', $request->cliente)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif ($request->factura_tipo) {
                $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])
                    ->where('fk_tipo', $request->factura_tipo)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif ($request->cliente) {
                $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])
                    ->where('fk_cliente', $request->cliente)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $facturas = Facturas::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc')->get();
            }

        } elseif ($request->factura_tipo) {
            if ($request->cliente) {
                $facturas = Facturas::where('fk_tipo', $request->factura_tipo)
                    ->where('fk_cliente', $request->cliente)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $facturas = Facturas::where('fk_tipo', $request->factura_tipo)->orderBy('id', 'desc')->get();
            }
        } elseif ($request->cliente) {
            $facturas = Facturas::where('fk_cliente', $request->cliente)->orderBy('id', 'desc')->get();
        } else {
            $facturas = Facturas::orderBy('id', 'desc')->get();
        }

        $clientes = Clientes::all();
        $clienteSeleccionado = $request->cliente;
        $fechaInicialSeleccionada = $request->firstDate;
        $fechaFinalSeleccionada = $request->lastDate;
        $tipoSeleccionado = $request->factura_tipo;

        return view('facturacion.listadoIngresos', [
            'facturas'                 => $facturas,
            'clientes'                 => $clientes,
            'clienteSeleccionado'      => $clienteSeleccionado,
            'fechaInicialSeleccionada' => $fechaInicialSeleccionada,
            'fechaFinalSeleccionada'   => $fechaFinalSeleccionada,
            'tipoSeleccionado'         => $tipoSeleccionado,
        ]);
    }

    /**
     * Muestra el detalle del ingreso
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showIngreso($id)
    {
        $factura = Facturas::find($id);
        return view('facturacion.ingreso', [
            'factura' => $factura
        ]);
    }

    public function showEditForm($id)
    {
        $factura = Facturas::find($id);
        $clientes = Clientes::all();
        $productos = Productos::all();

        if($factura->fk_tipo == 1){
            return view('facturacion.editCompra', [
                'factura'   => $factura,
                'clientes'  => $clientes,
                'productos' => $productos
            ]);
        }
        return view('facturacion.editVenta', [
            'factura'   => $factura,
            'clientes'  => $clientes,
            'productos' => $productos
        ]);
    }

    public function editarFactura(Request $request)
    {
        DB::beginTransaction();
//        $productos = json_decode($request->json_productos);

        /** @var $factura Facturas */
        $factura = Facturas::find($request->id);

        if($factura->fk_tipo == 1) {
            $resultado = $this->editarFacturaCompra($factura, $request);
        } elseif ($factura->fk_tipo == 2) {
            $resultado = $this->editarFacturaVenta($factura, $request);
        } else {
            return redirect()->route('facturacion.listado')
                ->with('message.error', 'Hubo un error encontrando el tipo de factura.');
        }

        return redirect()->route('facturacion.listado')
            ->with($resultado["estado"], $resultado["mensaje"]);
    }

    public function editarFacturaVenta($factura, $request){
        $factura->descripcion = $request->descripcion;
        $factura->monto_total = $request->monto_total;
        $factura->flete = $request->flete;
        $factura->utilidadTotal = $request->utilidadTotal ?? NULL;
        try {
            $factura->save();
//            foreach ($productos as $producto){
//                $factura->productos()->attach($producto->id,[
//                    'cantidad' => $producto->cantidad,
//                    'precio' => $producto->precioUnitario,
//                    'disponible' => $producto->cantidad
//                ]);
//                $prodEnDb = Productos::find($producto->id);
//                $prodEnDb->stock = $prodEnDb->stock + $producto->cantidad;
//                $prodEnDb->save();
//            }

            DB::commit();
            return ["estado" => "message.success", "mensaje" => 'Venta editada con éxito.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["estado" => "message.error", "mensaje" => $e->getMessage()];
        }
    }

    public function editarFacturaCompra($factura, $request){
        $factura->descripcion = $request->descripcion;
        $factura->monto_total = $request->total;
        $factura->flete = $request->flete;
        $factura->fk_cliente = $request->cliente ?? NULL;
        $listadoProductos = json_decode($request->json_productos);
        $idsProductos = array();
        try {
            foreach ($listadoProductos as $productoListado) {
                $producto = $factura->productos()->find($productoListado->id);
                if ($producto !== null) {
                    $factura->productos()->updateExistingPivot($productoListado->id,
                        [
                            'cantidad'   => $productoListado->cantidad,
                            'disponible' => $productoListado->cantidad,
                            'precio'     => $productoListado->precio
                        ]);
                } else {
                    $factura->productos()->attach($productoListado->id,[
                        'cantidad' => $productoListado->cantidad,
                        'precio' => $productoListado->precioUnitario,
                        'disponible' => $productoListado->cantidad
                    ]);
                }
                $idsProductos[] = $productoListado->id;
            }
            $productosQueFaltan = $factura->productos()->whereNotIn('fk_producto', $idsProductos)->get();

            foreach ($productosQueFaltan as $productoBasura){
                $factura->productos()->detach([$productoBasura->id]);
            }

            $factura->save();
            DB::commit();
            return ["estado" => "message.success", "mensaje" => 'Compra editada con éxito.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["estado" => "message.error", "mensaje" => $e->getMessage()];
        }
    }
}
