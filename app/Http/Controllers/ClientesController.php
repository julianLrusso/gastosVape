<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Facturas;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Muestra un listado de clientes
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function all()
    {
        $clientes = Clientes::withTrashed()
            ->orderBy('deleted_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('clientes.listado', [
            'clientes' => $clientes,
        ]);
    }

    public function show($id){
        $cliente = Clientes::withTrashed()->findOrFail($id);
        $facturas = Facturas::where('fk_cliente','=',$id)->get();
        return view('clientes.cliente', [
            'cliente' => $cliente,
            'facturas' => $facturas
        ]);
    }

    public function createForm()
    {
        return view('clientes.add');
    }

    /**
     * Crea un cliente
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $data = $request->all();

        $request->validate(Clientes::rules(), Clientes::rulesMessages());

        Clientes::create($data);

        return redirect()->route('clientes.listado')
            ->with('message.success', 'El Cliente <b>' .$data['nombre']. '</b> fue creado con éxito');
    }

    /**
     * Updatea un cliente en la base de datos
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $request->validate(Clientes::rules(), Clientes::rulesMessages());
        $data = $request->all();

        $cliente = Clientes::findOrFail($id);

        $cliente->update($data);

        return redirect()->route('clientes.show', ['id' => $id])
            ->with('message.success', 'El cliente se actualizó correctamente');
    }

    /**
     * Elimina un cliente
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $cliente = Clientes::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.listado')
            ->with('message.success', 'El cliente <b>' .$cliente->nombre. '</b> fue eliminado con éxito');
    }

    /**
     * Restaura un cliente eliminado
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $cliente = Clientes::withTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('clientes.show', ['id' => $id])
            ->with('message.success', 'El cliente <b>' .$cliente->nombre. '</b> fue restaurado con éxito');
    }
}
