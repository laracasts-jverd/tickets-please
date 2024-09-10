<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated($request->all());
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Unauthorized', 401);
        }
        $user = User::firstWhere('email', $request->get('email'));

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken($user->email)->plainTextToken,
            ]
        );
    }

    public function register(): JsonResponse
    {
        return $this->ok('register', []);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Logged out', []);
    }
}
