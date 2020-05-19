<?php

namespace Hu\Auth;

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
    private function loginSuccessResponse()
    {
        return response()->json([
            'result' => [
                'message' => 'Login success',
                'user' => AuthModel::authenticated()->loginInfo()
            ]
        ]);
    }
}
