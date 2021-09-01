<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//-- sponsor: name, address, primary contact
        Schema::create('sponsors', function (Blueprint $table) {
            $table->increments('id');//$table->id();
			$table->string('name', 100); // VARCHAR(100)
			$table->string('code', 64); // VARCHAR(100)
			$table->string('address', 256);
			// sync and version management
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            /*$table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();*/
        });
		//-- sponsor: multiple secondary contacts
        Schema::create('sponsor_contacts', function (Blueprint $table) {
            $table->increments('id');//$table->id();
			$table->unsignedInteger('sponsor_id');
			$table->string('name', 100); // VARCHAR(100)
			$table->string('address', 256)->nullable();
			$table->string('phone', 32)->nullable();
			$table->string('mobile', 32)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('fax', 32)->nullable();
			// sync and version management
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            /*$table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();*/
        });
		// Super Admin: add a flag to users table...
        // Security Profile: sponsor level
        // Server only
        Schema::create('sponsor_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sponsor_id');
			$table->string('name', 64)->nullable();
			$table->string('description', 256)->nullable();

            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();			
        });
        // Profile items: determine access to individual actions in activities
        Schema::create('sponsor_profile_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sponsor_profile_id');
            $table->unsignedInteger('secure_model_id'); // constants
            // proetcetd actions
            $table->unsignedInteger('view')->nullable();
            $table->unsignedInteger('update')->nullable();
            $table->unsignedInteger('delete')->nullable();
            // json_actions: =>['full'=>0, read-only=>1, 'read-write'=>1,'delete'=>1, 'media'=>1],
            $table->string('json_actions', 255)->nullable(); // json

            // keep timestamps for sync. We need ts for each record
            // to determine updates for full table.
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            
            $table->unique(['sponsor_profile_id', 'secure_model_id'], 'unique_model_permission');
        });
        // Sponsor Users: users assigned to sponsor
        // Admin creates user with default password and assign to sponsor
        // Sponsor can assign studies to user with specific security profiles.
        Schema::create('sponsor_user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sponsor_id'); // constants
            $table->unsignedInteger('user_id');
            // nullable: may use as user filter for sponsor.
            // Highly unlikely - one sponsor in one db for security reasons.
            $table->unsignedInteger('sponsor_profile_id')->nullable();

            // keep timestamps for sync. We need ts for each record
            // to determine updates for full table.
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            # one profile per user for at sponsor level
            $table->unique(['sponsor_id', 'user_id', 'sponsor_profile_id'], 'sponsor_user_profile');
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sponsor_profile_id')->references('id')->on('sponsor_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsors');
		Schema::dropIfExists('sponsor_contacts');
        Schema::dropIfExists('sponsor_profiles');
        Schema::dropIfExists('sponsor_profile_permissions');
        Schema::dropIfExists('sponsor_user_profiles');
    }
}
