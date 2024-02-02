<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            // Verifikasi token
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                // Token tidak valid
                return response()->json(['error' => 'Invalid token'], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                // Token telah kedaluwarsa
                return response()->json(['error' => 'Token expired silahkan refresh browser anda dan login kembali'], 401);
            } else {
                // Token tidak ditemukan
                return response()->json(['error' => 'Token not found'], 401);
            }
        }

        return $next($request);
    }
}
