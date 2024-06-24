<?php

namespace AbnCms\RolesPermission\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    public function rolePermissions(){
        return $this->hasMany(RolePermission::class);
    }
}
