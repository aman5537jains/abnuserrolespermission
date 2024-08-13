<?php

namespace AbnCms\RolesPermission\Controllers;

use Aman5537jains\AbnCmsCRUD\AbnCmsBackendController;

use AbnCms\RolesPermission\Models\Role;
use AbnCms\RolesPermission\Models\Permission;
use AbnCms\RolesPermission\Models\UserRole;
use Aman5537jains\AbnCmsCRUD\Components\InputComponent;
use Aman5537jains\AbnCmsCRUD\Components\SelectComponent;
use Aman5537jains\AbnCmsCRUD\Layouts\MultiFormBuilder;
use Aman5537jains\AbnCmsCRUD\Layouts\RelationalFormBuilder;
use Aman5537jains\AbnCmsCRUD\Layouts\SingleFieldMultipleValueFormBuilder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends AbnCmsBackendController
{
    public $uniqueKey="id";
    public static $module="users";
    public static $moduleTitle="Users";

    function getModel()
    {
        return User::class;
    }

    function viewBuilder($model)
    {
        $builder = parent::viewBuilder($model);
        $builder->onlyFields(["name","email","actions"]);
        $actions= $builder->getField("actions");
        $actions->setConfig("afterRender",function($component){
            $data =$component->getData('row');

            if($data->id==1){

                $component->setView("");
            }
        });
        return $builder;
    }
    function formBuilder($model = null)
    {

        $builder = parent::formBuilder($model);

        $relationalForm =  new SingleFieldMultipleValueFormBuilder(["name"=>"roles"],$builder);

        $relationalForm->addField("role_id",new SelectComponent(["type"=>"select","name"=>"role_id","attr"=>["multiple"=>true],"multiple"=>true,"options"=>Role::pluck("name","id")]));
        $builder->addField("roles",$relationalForm);
        $builder->onlyFields(["name","email","password","roles","submit"]);
        $password = $builder->fields["password"]->setConfig("type","password");

        if($model->exists){
             $password->setValidations([]);
        }

        if(request()->isMethod("post") || request()->isMethod("patch")){

            $builder->setConfig("beforeSave",function($f,$model){
                if(request()->get("password","")!=''){
                    $model->password = bcrypt($f->getField("password")->getValue());
                }
                return $model;
            });
        }

        return $builder;
    }


}
