<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
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
        if(!session()->has('users') && ($request -> path() != 'Auth/login' && $request -> path() != 'Auth/register')){
            return redirect('Auth/login')->with('fail', 'You must be login');
        }
        if(session()->has('users') && ($request->path() == 'Auth/login' || $request->path() == 'Auth/register' ) ){
            return back();
        }
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','Sat 01 Jan 1990 00:00:00 GMT');
    }
}
