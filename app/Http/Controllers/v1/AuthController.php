<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => [
                "required",
                "email"
            ],
            "password" => [
                "required",
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only("email", "password");

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(
                ['errors' => [
                    'auth' => [
                        'Unauthorized'
                    ],
                ]],
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