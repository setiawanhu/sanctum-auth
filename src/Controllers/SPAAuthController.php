<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Hu\Auth\CookieAuthentication;
use Hu\Auth\UserAuthentication;

class SPAAuthController extends Controller
{
    use UserAuthentication,
        CookieAuthentication;
}
