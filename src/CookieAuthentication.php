<?php

namespace Hu\Auth;

use Hu\Auth\Exceptions\InvalidCredentialException;
use Hu\Auth\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * @package Hu\Auth\Controllers
 */
trait CookieAuthentication
{
    /**
     * Handle a login attempt.
     *
     * @param AuthRequest $request
     * @return JsonResponse
     * @throws InvalidCredentialException
     */
    public function login(AuthRequest $request)
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

        throw new InvalidCredentialException();
    }

    /**
     * Handle a logout request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'result' => 'Logout success'
        ]);
    }

    /**
     * Generate login success response.
     *
     * @return JsonResponse
     */
    protected function loginSuccessResponse()
    {
        return response()->json([
            'result' => [
                'message' => 'Login success',
                'user' => AuthModel::authenticated()->loginInfo()
            ]
        ]);
    }
}
