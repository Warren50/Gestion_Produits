<?php

namespace App;

use Laratrust\Models\LaratrustRole;
class Role extends LaratrustRole
{
    public $guarded = [];

    public function role(){
        return $this->belonsToMany(Role::class, 'role_user');
    }
}
