<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); //creates an auto-incrementing UNSIGNED BIGINT (primary key) column
            $table->string('name', 100); // string('name', 100) => VARCHAR(100)
			$table->string('email', 100)->unique();
            $table->string('password', 256);
            
			$table->string('code', 100)->nullable();
			$table->string('fname', 100)->nullable();
            $table->string('lname', 100)->nullable();
            $table->string('mobile', 32)->nullable();
			$table->string('timezone', 128)->nullable();
            $table->unsignedInteger('profile')->nullable(); // security profile (admin user)

            $table->timestamp('email_verified_at');
            $table->timestamp('disabled_at')->nullable();
            $table->rememberToken(); //a nullable, VARCHAR(100)
            
            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->timestamp('version_at')->nullable();
            $table->string('version_text', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
