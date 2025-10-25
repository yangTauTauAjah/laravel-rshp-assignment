<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        // Check if user has any of the required roles
        $user = Auth::user();
        
        if (empty($roles)) {
            // No specific roles required, just authentication
            return $next($request);
        }

        // Check if user has any of the specified roles
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // User doesn't have required role
        return redirect()->route('home')
            ->with('error', 'Anda tidak memiliki akses ke halaman ini. Diperlukan role: ' . implode(' atau ', $roles));
    }
}

