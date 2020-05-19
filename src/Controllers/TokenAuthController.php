<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Hu\Auth\TokenAuthentication;
use Hu\Auth\UserAuthentication;

class TokenAuthController extends Controller
{
    use UserAuthentication,
        TokenAuthentication;
}
