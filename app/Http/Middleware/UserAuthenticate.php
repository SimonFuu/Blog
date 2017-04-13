<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserAuthenticate
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
        if (Auth::check()) {
            return $next($request);
        } else {
            return redirect() -> back() -> with('error', '登录超时，请先<a href="#" data-toggle="modal" data-target="#login-modal">登录</a>');
        }
    }
}
