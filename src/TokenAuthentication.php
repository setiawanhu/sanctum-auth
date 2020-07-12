<?php


namespace Hu\Auth;

use Hu\Auth\Exceptions\InvalidCredentialException;
use Hu\Auth\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

trait TokenAuthentication
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

        $user = $this->user->where($this->username(), '=', $credentials[$this->username()])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $this->loginSuccessResponse($user);
        }

        throw new InvalidCredentialException();
    }

    /**
     * Handle a logout request.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        AuthModel::revokeCurrentAccessToken();

        return $this->logoutSuccessResponse();
    }

    /**
     * Generated logout success response.
     *
     * @return JsonResponse
     */
    protected function logoutSuccessResponse()
    {
        return response()->json([
            'result' => 'Logout success'
        ]);
    }

    /**
     * Generate login success response.
     *
     * @param AuthModel $user
     * @return JsonResponse
     */
    protected function loginSuccessResponse(AuthModel $user)
    {
        return response()->json([
            'result' => [
                'message' => 'Login success',
                'token' => $user->createToken('auth-token')->plainTextToken
            ]
        ]);
    }
}
