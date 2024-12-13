<?php

namespace App\Helpers;

use App\Helpers\ResponseCode;
use Illuminate\Http\Response;

trait ApiResbonse
{
    protected function successResponse($data = [])
    {
        return response()->json($data, Response::HTTP_OK);
    }

    protected function errorResponse($message)
    {
        return response()->json(['message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function internalErrorResponse()
    {
        $errorMessage = __('messages.' . ResponseCode::ERROR_SEVER);
        return response()->json(['message' => $errorMessage], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
