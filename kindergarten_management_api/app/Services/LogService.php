<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LogService
{
    public function info($message, $data = [])
    {
        Log::info($message, $data);
    }

    public function warning($message, $data = [])
    {
        Log::warning($message, $data);
    }

    public function error($message)
    {
        Log::error($message);
    }

    public function debug($message, $data = [])
    {
        Log::debug($message, $data);
    }
}
