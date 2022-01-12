<?php

namespace App\Http\Middleware;

use Closure;

class MustBeLead
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
            return $next($request);
            // return redirect('/approvalsaleplan');
        }
        // return redirect('alert');
        abort(403, 'คุณไม่มีสิทธิ์ใช้งานหน้านี้');
    }
}
