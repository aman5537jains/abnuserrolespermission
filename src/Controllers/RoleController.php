<?php

namespace AbnCms\RolesPermission\Controllers;

use AbnCms\RolesPermission\Traits\Authorizable;
use App\Http\Controllers\Controller;
use AbnCms\RolesPermission\Models\Permission;
use AbnCms\RolesPermission\Models\Role;
use AbnCms\RolesPermission\Models\RolePermission;
use Aman5537jains\AbnCms\Lib\AbnCms;
use Aman5537jains\AbnCmsCRUD\AbnCmsBackendController;
use Aman5537jains\AbnCmsCRUD\Components\LinkComponent;
use Illuminate\Http\Request;

class RoleController extends AbnCmsBackendController
{
    public $uniqueKey="id";
    public static $module="roles";
    public static $moduleTitle="Roles";

    function getModel()
    {
        return Role::class;
    }
    public static function getRoutes($RouteService=null){

        $RouteService->get("rolePermissions","role-permissions/{slug}");
        $RouteService->post("syncPermissions","sync-permissions/{slug}");
        return $RouteService;
    }

    public function syncPermissions(Request $request,$slug){
        $permissions = $request->get("permissions");

        RolePermission::where("role_id",$slug)->delete();
        foreach($permissions as $module=>$actions){
            foreach($actions as $action){
                $RolePermission = new RolePermission;

                $RolePermission->role_id =$slug;
                $RolePermission->module_name =$module;
                $RolePermission->action =$action;
                $RolePermission->save();
            }

        }
        AbnCms::flash("Permissions updated successfully");
        return redirect()->back();

    }
    public function rolePermissions($slug){
        $permissions =  (RolePermission::where("role_id",$slug)->groupBy("module_name")->select("module_name",\DB::raw("group_concat(action) as actions"))->pluck("actions","module_name"));
        $all = [];
        foreach($permissions as $name=>$permission){
            $actions = explode(",",$permission);
            foreach($actions as $action){
                if(!isset($all[$name])){
                    $all[$name]=[];
                }
                $all[$name][$action]= $action;
            }
        }
        $permissionsList  = (Permission::groupBy("module_name")->select("module_name",\DB::raw("group_concat(action) as actions"))->pluck("actions","module_name"));
        $list = '<h2>Permission(s) List</h2> <br> <form method="POST" action="'.$this->action('syncPermissions',[$slug]).'" > '.csrf_field() .' <table class="table"> <tr><th>Module</th><th>Actions</th></tr>';

        foreach($permissionsList as $name=>$permissions){
            $actions = explode(",",$permissions);
            $td='';
            foreach($actions as $action){
                $checked = isset($all[$name][$action])?"checked":"";
                $td.="<input type='checkbox'  $checked name='permissions[$name][$action]'  value='$action'  /> $action";
            }
            $checked = isset($all[$name]["view"])?"checked":"";
            $list .= "<tr><td> <input  type='checkbox' $checked name='module_name[$name]' /> $name</td><td>  $td </td></tr>  ";
        }
        $list.="</table> <button>Save</button></form>";
        return $this->viewHtml($list);
    }

    public function viewBuilder($model)
    {
        $builder =parent::viewBuilder($model);
        $actions= $builder->getField("actions");

        $components = $actions->getConfig("components");

        $components[]= new LinkComponent(["link"=>"", "beforeRender"=>function($component){
            $data = $component->getData();

            $component->setConfig("link",$this->action("rolePermissions",[$data["row"]->{$this->uniqueKey}]));
         },
         "label"=>'<svg xmlns="http://www.w3.org/2000/svg" width=20 height=20 viewBox="0 0 32 40" x="0px" y="0px"><g data-name="Layer 2"><path d="M25,11H23V8a6,6,0,0,0-6-6H15A6,6,0,0,0,9,8v3H7a3,3,0,0,0-3,3V27a3,3,0,0,0,3,3H25a3,3,0,0,0,3-3V14A3,3,0,0,0,25,11ZM11,8a4,4,0,0,1,4-4h2a4,4,0,0,1,4,4v3H11ZM26,27a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V14a1,1,0,0,1,1-1H25a1,1,0,0,1,1,1Zm-8-8A2,2,0,0,1,17,20.75,1,1,0,0,1,17,21v2a1,1,0,0,1-2,0V21a1,1,0,0,1,.05-.25A2,2,0,1,1,18,19Z"></path></g></svg>']
        );
        $builder->getField("actions")->setConfig("components",$components);
        $actions->setConfig("afterRender",function($component){
            $data =$component->getData('row');

            if($data->id==1){

                $component->setView("");
            }
        });
        return $builder;
    }

}
