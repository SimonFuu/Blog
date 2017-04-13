<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class BackendAuthenticate
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
        if (Auth::check() && Auth::user() -> roleId == 1) {
            return $next($request);
        } else {
            return redirect('/') -> with('error', '您没有该权限!');
        }
    }
}
