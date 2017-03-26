<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Users who belong to this role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'users_roles', 'user_id', 'role_id');
    }
}
