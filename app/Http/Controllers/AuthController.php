<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function formRegister()
    {
        return view('auth.register');
    }

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

    public function register(Request $request)
    {
        $request->validate(Usuario::rules(), Usuario::rulesMessages());

        $credenciales = [
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];
        Usuario::create($credenciales);
        return redirect()->route('auth.formLogin')
                ->with('message.success', '¡Usuario creado con éxito!');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('formLogin')->with('message.success', 'Sesión cerrada con éxito.');
    }
}
