<?php

namespace Hu\Auth\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package Hu\Auth\Models
 * @mixin Builder
 *
 * @property int id
 * @property string name
 * @property string created_at
 * @property string updated_at
 */
class Role extends Model
{
    protected $fillable = [
        'name'
    ];
}
