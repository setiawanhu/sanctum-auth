<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Hu\Auth\AuthModel;
use Hu\Auth\TokenAuthentication;
use Hu\Auth\UserAuthentication;

class TokenAuthController extends Controller
{
    use UserAuthentication,
        TokenAuthentication;

    /**
     * @var AuthModel
     */
    protected $user;

    /**
     * TokenAuthController constructor.
     *
     * @param AuthModel $user
     */
    public function __construct(AuthModel $user)
    {
        $this->user = $user;
    }
}
