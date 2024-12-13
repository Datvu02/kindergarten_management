<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Helpers\ResponseCode;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check() ) {
            return response()->json([
                'message' => __('message')[ResponseCode::FORBIDDEN],
            ], Response::HTTP_FORBIDDEN);
        }
        $allowedRoles = array_map('intval', explode(';', $role));

        $userRole = Auth::user()->authority->value;

        if (!in_array($userRole, $allowedRoles)) {
            return response()->json([
                'message' => __('message')[ResponseCode::FORBIDDEN],
            ], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
