<?php

namespace App\Http\Middleware;

use App\Helpers\DomainHelper;
use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomDomainAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Remove 'www.' prefix from the host for comparison
        $host = preg_replace('/^www\./i', '', $request->getHost());
        $mainDomain = config('app.domain');

        if ($host !== $mainDomain) {
            // Check if domain exists in our database (check both with and without www)
            $customDomain = Domain::query()
                ->where('name', $host)
                ->first();

            if (! DomainHelper::isVerifiedDomain($customDomain)) {
                abort(403, '❌ Domain is not verified or allowed');
            }

            if (! $customDomain->user->subscribed()) {
                abort(403, '❌ Domain is not verified or allowed');
            }

            $allowedRoutes = [
                'home',
                'livewire.update',
            ];

            if (! in_array($request->route()->getName(), $allowedRoutes)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
