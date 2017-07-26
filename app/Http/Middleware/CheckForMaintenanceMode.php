<?php

namespace App\Http\Middleware;

use Closure;

class CheckForMaintenanceMode
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
        $status = false;
        if ($status) {
            if ($request -> path() === 'maintenance') {
                return view('maintenance');
            } else {
                return redirect('maintenance', 304);
            }
        }
        return $next($request);
    }
}
