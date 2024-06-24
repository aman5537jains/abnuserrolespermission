<?php

namespace AbnCms\RolesPermission\Models;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public static function defaultPermissions()
    {
        return [
            "users"=>["view"=>"view","add"=>"add","edit"=>"edit","delete"=>"delete"],
            "roles"=>["view"=>"view","add"=>"add","edit"=>"edit","delete"=>"delete"],
            "cms"=>["view"=>"view","add"=>"add","edit"=>"edit","delete"=>"delete"],
            "menu-builder"=>["view"=>"view","add"=>"add","edit"=>"edit","delete"=>"delete"],
            "plugins"=>["view"=>"view","add"=>"add","edit"=>"edit","delete"=>"delete"],
            "settings"=>["view"=>"view","add"=>"add","edit"=>"edit","delete"=>"delete"]
        ];
    }

    public static function addPermissions($permissions){
        foreach($permissions as $module=>$permission){
            foreach($permission as $action=>$label){
                if(Permission::where("module_name",$module)->where("action",$action)->count()>0)
                    continue;

                $Permission = new Permission;
                $Permission->module_name= $module;
                $Permission->action= $action;
                $Permission->save();
                self::assignPermissionToSuperAdminRole($Permission);
            }
        }

    }
    public static function removePermissions($permissions){

        foreach($permissions as $module=>$permission){
            foreach($permission as $action=>$label){
                Permission::where("module_name",$module)->where("action",$action)->delete();
                RolePermission::where("module_name",$module)->where("action",$action)->delete();
            }
        }

    }

    public static function assignPermissionToSuperAdminRole($Permission){

        $RolePermission = new RolePermission;
        $RolePermission->role_id = 1;
        $RolePermission->module_name= $Permission->module_name;
        $RolePermission->action= $Permission->action;
        $RolePermission->save();

    }

}
