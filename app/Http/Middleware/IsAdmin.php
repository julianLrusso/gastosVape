<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        if ($user->rol == 'admin'){
            return $next($request);
        } else {
            return redirect()->route('home')->with('message.error', 'No puedes ingresar aquí.');
        }
    }
}
