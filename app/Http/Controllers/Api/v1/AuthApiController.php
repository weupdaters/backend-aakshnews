<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AuthLoginRequest;
use App\Http\Requests\Api\v1\AuthRegisterRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    use ApiResponse;

    /**
     * POST /api/v1/login or /login
     */
    public function login(AuthLoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->errorResponse('Invalid email or password credentials.', [
                'email' => ['Invalid credentials.']
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user'         => new UserResource($user),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 'Login successful.');
    }

    /**
     * POST /api/v1/register or /register
     */
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user'         => new UserResource($user),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 'Registration successful.', [], 201);
    }

    /**
     * POST /api/v1/logout or /logout (Authenticated)
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user && method_exists($user, 'currentAccessToken') && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return $this->successResponse(null, 'Successfully logged out.');
    }

    /**
     * GET /api/v1/me or /me (Authenticated)
     */
    public function me(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->errorResponse('Unauthenticated.', [], 401);
        }

        return $this->successResponse(new UserResource($user), 'Authenticated user details fetched.');
    }
}
