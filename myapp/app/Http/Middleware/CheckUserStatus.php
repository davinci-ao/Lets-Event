<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUserStatus
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
        if (Auth::user()->status == 'ban') {
            return redirect('/home');
        }
        return $next($request);
    }
}
