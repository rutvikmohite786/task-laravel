<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GuestCustome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(Auth::guard('web')->user()){
            if(request()->is('login')){
                return redirect()->route('user');
            } 
            if(request()->is('logout')){
                return $next($request);
            }
        }
        if(request()->is('custom-login')){
            return $next($request);
        }
        return $next($request);
    }
}

