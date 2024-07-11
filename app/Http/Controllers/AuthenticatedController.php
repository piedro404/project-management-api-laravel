<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthenticatedController extends Controller
{
    protected $user;

    public function __construct()
    {
        if (!$user = auth('api')->user()) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => [
                        'auth' => [
                            'Unauthorized'
                        ],
                    ]],
                    401
                )
            );
        }

        $this->user = User::find($user->id);
    }
}
