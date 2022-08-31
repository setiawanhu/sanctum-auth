<?php

namespace Hu\Auth;

use Hu\Auth\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AuthController
 *
 * @package Hu\Auth
 */
trait CookieAuthentication
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

        if ($this->guard()->attempt($credentials)) {
            $request->session()->regenerate();

            return $this->loginSuccessResponse();
        }

        return $this->loginFailedResponse();
    }

    /**
     * Handle a logout request.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function logout(Request $request): Response|JsonResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

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
     * @return JsonResponse|Response
     */
    protected function loginSuccessResponse(): Response|JsonResponse
    {
        return response()->json([
            'result' => [
                'message' => 'Login success',
                'user' => AuthModel::authenticated()->loginInfo()
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
