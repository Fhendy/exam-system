<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCheatingStrike
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        $strikes = session('exam_session.strikes', 0);
        
        // Kirim strike count ke frontend via header
        $response->headers->set('X-Strike-Count', $strikes);
        $response->headers->set('X-Max-Strikes', 3);
        
        return $response;
    }
}