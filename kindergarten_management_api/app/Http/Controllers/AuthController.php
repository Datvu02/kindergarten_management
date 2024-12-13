<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    protected $authService;

    protected $logService;

    public function __construct(
        AuthService $authService,
        LogService $logService
    ) {
        $this->authService = $authService;
        $this->logService = $logService;
    }
    public function login(LoginRequest $request):JsonResponse
    {
        $this->logService->info('login start:', $request->all());
        
        try {
            $result = $this->authService->login($request);
            if (isset($result['message'])) {
                $this->logService->warning('login:', $result);

                return $this->errorResponse($result['message']);
            }

            $this->logService->info('login finish successful');

            return $this->successResponse($result);
        } catch (\Exception $e) {
            $this->logService->error('login:'.$e->getMessage());

            return $this->internalErrorResponse();
        }
    }
}
