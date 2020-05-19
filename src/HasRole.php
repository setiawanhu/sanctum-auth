<?php


namespace Hu\Auth;

trait HasRole
{
    public function roles()
    {
        return $this->hasOne('roles');
    }
}
