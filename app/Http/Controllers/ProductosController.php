<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
    /**
     * Muestra un listado de productos
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function all()
    {
        $productos = Productos::withTrashed()
            ->orderBy('deleted_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('productos.listado', [
            'productos' => $productos,
        ]);
    }

    /**
     * Muestra el producto
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $producto = Productos::withTrashed()->findOrFail($id);
        return view('productos.producto', [
            'producto' => $producto
        ]);
    }

    /**
     * Retorna el formulario de creacion
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createForm()
    {
        return view('productos.add');
    }

    /**
     * Crea un producto en la base de datos
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $data = $request->all();

        $request->validate(Productos::rules(), Productos::rulesMessages());

        Productos::create($data);

        return redirect()->route('productos.listado')
            ->with('message.success', 'El producto <b>' .$data['nombre']. '</b> fue creado con éxito');
    }

    /**
     * Updatea un producto en la base de datos
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $request->validate(Productos::rules(), Productos::rulesMessages());
        $data = $request->all();

        $producto = Productos::findOrFail($id);

        $producto->update($data);

        return redirect()->route('productos.show', ['id' => $id])
            ->with('message.success', 'El producto se actualizó correctamente');
    }

    /**
     * Elimina un producto
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $producto = Productos::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.listado')
            ->with('message.success', 'El producto <b>' .$producto->nombre. '</b> fue eliminado con éxito');
    }

    /**
     * Restaura un producto eliminado
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $producto = Productos::withTrashed()->findOrFail($id);
        $producto->restore();

        return redirect()->route('productos.show', ['id' => $id])
            ->with('message.success', 'El producto <b>' .$producto->nombre. '</b> fue restaurado con éxito');
    }
}
