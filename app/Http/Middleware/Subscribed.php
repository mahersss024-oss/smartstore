<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $planName): Response
    {
        if (! $request->user()?->subscribedToPlan($planName)) {
            return redirect()->route('pages.pricing');
        }

        return $next($request);
    }
}
