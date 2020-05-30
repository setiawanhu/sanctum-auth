<?php

namespace Hu\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidRoleException extends Exception
{
    /**
     * Expected role.
     *
     * @var string
     */
    private $expected;

    /**
     * Actual role.
     *
     * @var string
     */
    private $actual;

    /**
     * InvalidRoleException constructor.
     *
     * @param string $expected
     * @param string $actual
     */
    public function __construct(string $expected, string $actual)
    {
        parent::__construct();

        $this->expected = $expected;
        $this->actual = $actual;
    }

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
                'message' => 'Forbidden.',
                'cause' => "Expected {$this->expected}, but actually {$this->actual}"
            ]
        ], 403);
    }
}
