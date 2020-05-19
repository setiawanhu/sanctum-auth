<?php


namespace Hu\Auth;

use Hu\Auth\Exceptions\InvalidCredentialException;
use Hu\Auth\Requests\AuthRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

trait UserAuthentication
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
