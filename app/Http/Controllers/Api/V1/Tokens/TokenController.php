<?php

namespace App\Http\Controllers\Api\V1\Tokens;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getToken()
    {
        $token = ApiToken::getActiveToken();
        $token_expires_at = date('d-m-Y h:i:s', strtotime($token->expires_at));

        return response()->json([
            'status' => true,
            'token' => $token->token,
            'token_expires_at' => $token_expires_at
        ]);
    }
}
