<?php

namespace App\Http\Middleware;

use Closure;

class SistemasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user() && auth()->user()->tieneSistemas()){
            return $next($request);
        }
        session()->flash('message', ['type' => 'warning', 'text' => 'Necesitas agregar al menos un sistema a tu cuenta']);
        return redirect('/');
    }
}
