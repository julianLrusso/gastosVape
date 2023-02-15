<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as User;
use Illuminate\Notifications\Notifiable;

class Usuario extends User
{
//    use HasFactory;
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'password'];

    //Reglas de validación
    public static function rules()
    {
        return [
            'email'                 => ['required','min:2', 'unique:App\Models\Usuario,email'],
            'password'              => ['required','min:6', 'confirmed'],
            'password_confirmation' => 'required|min:6'
        ];
    }

    public static function rulesMessages()
    {
        return [
            'email.required'                 => 'El usuario es obligatorio.',
            'password.required'              => 'El password es obligatorio.',
            'password.confirmed'             => 'Las contraseñas deben coincidir.',
            'password_confirmation.required' => 'Repetir la contraseña es obligatorio.',
            'email.unique'                   => 'El usuario ya está registrado.'
        ];
    }
}
