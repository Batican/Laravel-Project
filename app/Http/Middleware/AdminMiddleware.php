<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if(Auth::check()){
            if(Auth::user()->role()->id == 1) {

                return $next($request);
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }

        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        

        return $next($request);
    }
}
