<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if($user->hasRole('customer')){
            return to_route('home')->with('error', 'Sorry, You have no permission');
        }
        $allPermissions =  $user->roles[0]->getPermissionNames()->toArray();
        $requestRoute = request()->route()->getName();
        if (in_array($requestRoute, $allPermissions)) {
            return $next($request);
        }
        return to_route('root')->with('error', 'Sorry, You have no permission');
    }
}
