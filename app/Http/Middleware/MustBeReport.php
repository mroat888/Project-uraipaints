<?php

namespace App\Http\Middleware;

use Closure;

class MustBeReport
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
        if($user && $user->status == '1') {
            abort(403, 'คุณไม่มีสิทธิ์ใช้งานหน้านี้');
            // return view('saleman.dashboard');
        }
        // return redirect('alert');
        return $next($request);

    }
}
