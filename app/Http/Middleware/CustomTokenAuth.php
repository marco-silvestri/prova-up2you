<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\UseToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as HttpCode;

class CustomTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return UseToken::comparison() ? $next($request)
            : response('The token is not valid', HttpCode::HTTP_FORBIDDEN);
    }
}
