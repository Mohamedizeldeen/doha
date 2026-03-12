<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            // Check if account is blocked (skip for super_admin)
            if (!in_array('super_admin', $roles) && !auth()->user()->is_active) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => __('admin.account_blocked_message'),
                ]);
            }

            return $next($request);
        }

        return redirect('/');
    }
}
