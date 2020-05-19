<?php

namespace Hu\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidCredentialException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json([
            'result' => [
                'message' => 'Unauthenticated.'
            ]
        ], 401);
    }
}
