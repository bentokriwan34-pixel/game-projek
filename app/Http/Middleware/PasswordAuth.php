<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is already authenticated
        if (session('authenticated')) {
            return $next($request);
        }

        // Check if password is provided in request
        if ($request->has('password')) {
            $password = $request->input('password');
            $correctPassword = env('GAME_PASSWORD', 'tictactoe123'); // Default password
            
            if ($password === $correctPassword) {
                session(['authenticated' => true]);
                return $next($request);
            }
        }

        // If not authenticated, show login form
        return response()->view('auth.login');
    }
}
