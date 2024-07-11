<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\{
    UserRequest,
    TokenRequest,
    ResetPasswordRequest,
};
use App\Http\Resources\{
    UserResource,
    TokenResource,
};
use App\Models\User;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $request['password'] = bcrypt($request->password);

        User::create($request->all());

        return response()->json(
            ['message' => 'Successfully created user'],
            201
        );
    }

    public function login(TokenRequest $request)
    {
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
        return new UserResource(User::find(auth('api')->user()->id)->load('projects'));
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

    public function edit_profile(UserRequest $request)
    {
        $user = User::find(auth('api')->user()->id);

        if ($request->password) {
            $request['password'] = bcrypt($request->password);
            auth('api')->logout();
        }

        $user->update($request->all());

        return response()->json(
            ['message' => 'Successfully user profile'],
            201
        );
    }

    public function reset_password(ResetPasswordRequest $request)
    {
        $user = User::find(auth('api')->user()->id);

        if ($request->code != "A1B2C3D4") {
            return response()->json(
                ['errors' => [
                    'code' => [
                        'Token reset password is invalid'
                    ],
                ]],
                400
            );
        }

        $user->password = bcrypt($request->password);
        $user->save();

        auth('api')->logout();

        return response()->json(
            ['message' => 'Successfully reset password'],
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