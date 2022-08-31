<?php

namespace Hu\Auth;

use Hu\Auth\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Trait TokenAuthentication
 *
 * @package Hu\Auth
 */
trait TokenAuthentication
{
    /**
     * Handle a login attempt.
     *
     * @param AuthRequest $request
     * @return JsonResponse|Response
     */
    public function login(AuthRequest $request): Response|JsonResponse
    {
        $validated = $request->validated();

        $credentials = [
            $this->username() => $validated['username'],
            'password' => $validated['password']
        ];

        $user = $this->user->where($this->username(), '=', $credentials[$this->username()])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $this->loginSuccessResponse($user);
        }

        return $this->loginFailedResponse();
    }

    /**
     * Handle a logout request.
     *
     * @return JsonResponse|Response
     */
    public function logout(): Response|JsonResponse
    {
        AuthModel::revokeCurrentAccessToken();

        return $this->logoutSuccessResponse();
    }

    /**
     * Generated logout success response.
     *
     * @return JsonResponse|Response
     */
    protected function logoutSuccessResponse(): Response|JsonResponse
    {
        return response()->json([
            'result' => 'Logout success'
        ]);
    }

    /**
     * Generate login success response.
     *
     * @param AuthModel $user
     * @return JsonResponse|Response
     */
    protected function loginSuccessResponse(AuthModel $user): Response|JsonResponse
    {
        return response()->json([
            'result' => [
                'message' => 'Login success',
                'token' => $user->createToken('auth-token')->plainTextToken
            ]
        ]);
    }

    /**
     * Generate login failed response.
     *
     * @return JsonResponse|Response
     */
    protected function loginFailedResponse(): Response|JsonResponse
    {
        return response()->json([
            'result' => [
                'message' => 'Unauthenticated.'
            ]
        ], 401);
    }
}
