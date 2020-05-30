<?php


namespace Hu\Auth;

use Hu\Auth\Models\Role;

/**
 * Trait HasRole
 *
 * @package Hu\Auth
 *
 * @property int role_id
 * @property Role role
 */
trait HasRole
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
