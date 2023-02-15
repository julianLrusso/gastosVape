<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function formLogin()
    {
        return view('auth.login');
    }

    /**
     * Muestra el formulario de registro
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function formRegister()
    {
        return view('auth.register');
    }

    /**
     * Hace el login
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {

        $credenciales = [
          'email' => $request->input('email'),
          'password' => $request->input('password'),
        ];

        if (!auth()->attempt($credenciales)){
            return redirect()->route('auth.formLogin')->withInput()->with('message.error', 'Los datos no coinciden.');
        }

        return redirect()->route('home')->with('message.success', 'Inicio de sesión exitoso.');
    }

    /**
     * Registra usuarios
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate(Usuario::rules(), Usuario::rulesMessages());

        $credenciales = [
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];
        Usuario::create($credenciales);
        return redirect()->route('usuarios.listado')
                ->with('message.success', '¡Usuario creado con éxito!');
    }

    /**
     * Cambia la contraseña
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request){
        $request->validate([
            'password'              => ['required','min:6', 'confirmed'],
            'password_confirmation' => 'required|min:6'
        ], [
            'password.required'              => 'El password es obligatorio.',
            'password.confirmed'             => 'Las contraseñas deben coincidir.',
            'password_confirmation.required' => 'Repetir la contraseña es obligatorio.',
        ]);

        $usuario = Usuario::findOrFail($request->idUsuario);

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('usuarios.listado')
            ->with('message.success', '¡Contraseña cambiada con éxito!');
    }

    /**
     * Cierra sesión
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('formLogin')->with('message.success', 'Sesión cerrada con éxito.');
    }
}
