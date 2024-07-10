<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        Log::info("Entrou");
        $credentials = $request->only("email", "password");

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(
                ['error' => 'Unauthorized'],
                401
            );
        }
        
        return response()->json(
            ['data' => new TokenResource($token)],
            201
        );
    }

    public function me()
    {
        return response()->json(
            ['data' => auth('api')->user()],
            200
        );
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(
            ['message' => 'Successfully logged out'],
            200
        );
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json(
            new TokenResource($token),
            201
        );
    }
}

// return response()->json(
//     ['data' => [
//         'token' => $token,
//         'token_typ' => 'bearer',
//         'expires_in' => auth('api')->factory()->getTTL() * 60
//     ]],
//     200
// );