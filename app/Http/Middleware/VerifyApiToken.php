<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'status' => false,
                'message' => 'Missing or invalid Authorization header',
            ], 401);
        }

        $tokenValue = str_replace('Bearer ', '', $authHeader);
        $currentToken = ApiToken::getActiveToken(); 

        if ($tokenValue !== $currentToken->token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized — Invalid or expired token',
            ], 401);
        }
        
        return $next($request);
    }
}
