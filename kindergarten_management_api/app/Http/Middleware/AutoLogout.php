<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TActionHist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use App\Services\LogService; 


class AutoLogout
{
    protected $logService;

    public function __construct(
        LogService $logService
    ){
        $this->logService = $logService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (! Cache::get('system_idle_timeout_' . Auth::user()->id)) {
            if (! strpos($request->url(), 'api/logout')) {
                TActionHist::create([
                    'operation_type' => TActionHist::EXPIRED_TOKEN,
                    'operation_dt' => now(),
                    'user_id' => Auth::user()->user_id,
                    'created_by' => Auth::user()->user_id,
                    'updated_by' => Auth::user()->user_id
                ]);

                $this->logService->info('false');

                return \response()->json([
                    'message' => 'Unauthorized'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } else {
            $timeOut = (int)config('constants.system_idle_timeout') * 60;
            Cache::put('system_idle_timeout_' . Auth::user()->id, now()->addMinutes((int)config('constants.system_idle_timeout'))->format('Y-m-d H:i:s'), $timeOut);
            $this->logService->info('done');
        }

        return $next($request);
    }
}
