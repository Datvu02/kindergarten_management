<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TActionHist;
use App\Models\RefreshToken;
use App\Helpers\ResponseCode;
use Illuminate\Support\Facades\Hash;

class AuthService 
{
    public function login($request)
    {
        $user = User::where("name_id", $request->name_id)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return [
                'message' => __('message')[ResponseCode::ERROR_INCORRECT_NAME_ID_OR_PASSWORD],
            ];
        }

        $expiresAt = Carbon::now()->addDays(30);
        $accessToken = $user->createToken('apiToken', ['*'], $expiresAt)->plainTextToken;

        RefreshToken::insert([
            'user_id' => $user->id,
            'token' => hash('sha256', $accessToken),
            'expired_at' => $expiresAt,
        ]);

        // dd($user);
        TActionHist::create([
            'operation_type' => TActionHist::LOGIN,
            'operation_dt' => now(),
            'user_id' => $user->id,
            'created_by' => $user->name_id,
            'updated_by' => $user->name_id
        ]);

        return [
            'access_token' => $accessToken,
            'name_id' => $user->name_id,
            'name' => $user->user_name,
            'authority' => $user->authority->name
        ];
    }
}