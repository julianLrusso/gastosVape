<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Listado de usuarios
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getAll()
    {
        $usuarios = Usuario::get();

        return view('usuarios.listado',[
            'usuarios' => $usuarios
        ]);
    }

    /**
     * Muestra el formulario de cambio de contraseña
     * @param $idUsuario
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function changePasswordForm($idUsuario){
        $usuario = Usuario::findOrFail($idUsuario);

        return view('usuarios.changePassword',[
            'usuario' => $usuario
        ]);
    }

    public function eraseUsuario(Request $request)
    {
        $usuario = Usuario::findOrFail($request->idUsuario);

        $usuario->delete();

        return redirect()->route('usuarios.listado')
            ->with('message.success', '¡Usuario eliminado con éxito!');
    }
}
