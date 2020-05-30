<?php

namespace Hu\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class AuthModel
 *
 * @package Hu\Auth
 */
abstract class AuthModel extends User
{
    use HasApiTokens,
        HasAuthInfo;

    /**
     * Token constant.
     */
    public const TOKEN = 'token';

    /**
     * SPA constant.
     */
    public const SPA = 'spa';

    /**
     * Revoke guest's token.
     *
     * @return void
     */
    static function revokeCurrentAccessToken()
    {
        $user = self::authenticated();

        $user->tokens()
            ->where('id', '=', $user->currentAccessToken()->id)
            ->delete();
    }

    /**
     * Get authenticated user.
     *
     * @return AuthModel|Authenticatable|null
     */
    static function authenticated()
    {
        return auth()->user();
    }
}
