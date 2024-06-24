<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       \DB::statement("CREATE TABLE  `user_roles` (`id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `role_id` INT(11) NOT NULL , `updated_at` DATETIME NOT NULL , `created_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
