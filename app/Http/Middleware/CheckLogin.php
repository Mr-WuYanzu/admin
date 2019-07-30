<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        $token = $_COOKIE['admin_token']??null;
        if(empty($token)){
            return redirect()->away('/login');
        }
        return $next($request);
    }
}
