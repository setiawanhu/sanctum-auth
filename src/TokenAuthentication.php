<?php


namespace Hu\Auth;

use Illuminate\Http\JsonResponse;

trait TokenAuthentication
{
    /**
     * Handle a logout request.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        AuthModel::revokeCurrentAccessToken();

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
                'token' => AuthModel::authenticated()->createToken('auth-token')->plainTextToken
            ]
        ]);
    }
}
