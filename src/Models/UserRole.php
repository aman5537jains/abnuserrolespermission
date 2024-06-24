<?php

namespace AbnCms\RolesPermission\Models;
use Illuminate\Database\Eloquent\Model;
class UserRole extends Model
{
    public function roles(){
        return $this->belongsTo(Role::class);
    }
}
