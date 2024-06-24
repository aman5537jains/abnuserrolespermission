<?php

use AbnCms\RolesPermission\Controllers\RoleController;
use AbnCms\RolesPermission\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group( ['middleware' => ['web','auth'],"prefix"=>"cpadmin"], function() {
    UserController::resource();
    RoleController::resource();
});
