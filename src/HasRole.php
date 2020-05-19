<?php


namespace Hu\Auth;

use Hu\Auth\Models\Role;

trait HasRole
{
    public function role()
    {
        return $this->hasOne(Role::class);
    }
}
