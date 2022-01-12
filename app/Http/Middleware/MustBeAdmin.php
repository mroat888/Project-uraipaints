<?php

namespace App\Http\Middleware;

use Closure;

class MustBeAdmin
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
        $user = $request->user();
        if($user && $user->status == '3') {
            return $next($request);
            // return view('saleman.dashboard');
        }
        // return redirect('alert');
        abort(403, 'คุณไม่มีสิทธิ์ใช้งานหน้านี้');
    }
}
