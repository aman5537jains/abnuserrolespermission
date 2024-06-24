<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("CREATE TABLE  `role_permissions` (`id` INT(11) NOT NULL AUTO_INCREMENT , `role_id` INT(11) NOT NULL , `module_name` VARCHAR(255) NOT NULL , `action` VARCHAR(255) NOT NULL , `updated_at` DATETIME NOT NULL , `created_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
