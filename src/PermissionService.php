<?php

namespace AbnCms\RolesPermission;

use AbnCms\RolesPermission\Models\RolePermission;
use AbnCms\RolesPermission\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class PermissionService {
    public static $userPermissions=[];
    public static $loaded=false;

    public static function loadPermissions(){
        if(!self::$loaded){
            $userid = Auth::id();

            $userRoles = UserRole::whereUserId($userid)->pluck("role_id");

            foreach($userRoles as $role){
                $permissions = RolePermission::whereRoleId($role)->get();

                foreach($permissions as $permission){
                    self::$userPermissions[$permission->module_name][$permission->action]=$permission->action;
                }

            }
            self::$loaded =true;
        }

         return self::$userPermissions;

    }

    public static  function getPermission($module,$action){
        self::loadPermissions();
        return self::$userPermissions;
    }

    public static function has($module,$name){
        self::loadPermissions();

        return isset(self::$userPermissions[$module][$name]);
    }
    public static function hasOrAbort($module,$name){
        if(!self::has($module,$name)){
            return abort(403);
        }
        return true;
    }



}
