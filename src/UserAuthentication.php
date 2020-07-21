<?php

namespace Hu\Auth;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

trait UserAuthentication
{
    /**
     * Get User's username field.
     *
     * @return string
     */
    protected function username()
    {
        return 'email';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Handle a user info request.
     *
     * @return JsonResponse
     */
    public function user()
    {
        return response()->json([
            'result' => AuthModel::authenticated()->info()
        ]);
    }
}
