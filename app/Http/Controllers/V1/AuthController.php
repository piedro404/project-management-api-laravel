<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");

        if (!$token = auth("api")->attempt($credentials)) {
            return response()->json(
                ['error' => 'Unauthorized'],
                401
            );
        }

        return response()->json(
            ['data' => auth()->user()],
            0
        );
    }
}
