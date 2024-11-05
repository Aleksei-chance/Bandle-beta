<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->path() == 'auth' && auth(guard: "web")->check()) {
            return redirect('/user/bandle');
        }
        else if ($request->path() != 'auth' && !auth(guard: "web")->check())
        {
            return redirect('/auth');
        }

        return $next($request);
    }
}
