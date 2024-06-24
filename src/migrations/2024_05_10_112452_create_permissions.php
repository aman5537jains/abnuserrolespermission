<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("CREATE TABLE  `permissions` (`id` INT(11) NOT NULL AUTO_INCREMENT , `module_name` VARCHAR(255) NOT NULL ,`action` VARCHAR(255) NOT NULL, `status` ENUM('1','0') NOT NULL , `updated_at` DATETIME NOT NULL , `created_at` DATETIME NOT NULL ,  PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
