<?php


namespace Hu\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait AuthInfo
 *
 * This trait used to get authenticated user's information.
 *
 * @package Hu\Auth
 *
 * @property int id
 * @method Builder accountInfo()
 */
trait HasAuthInfo
{
    /**
     * Get authenticated user's detailed info.
     *
     * @return User|Model
     */
    public function info()
    {
        return $this->accountInfo()->findOrFail($this->id);
    }


    /**
     * Get authenticated user's login info after authenticated.
     *
     * @return AuthModel|array
     */
    public abstract function loginInfo();

    /**
     * Scope a query to get user account information.
     *
     * @param Builder $query
     * @return Builder
     */
    public abstract function scopeAccountInfo(Builder $query);
}
