<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {	
        // sponsor => protocol => study
        Schema::create('studies', function (Blueprint $table) {
            $table->increments('id');//$table->id();
            $table->unsignedInteger('protocol_id'); // Forign-Key
            $table->unsignedInteger('status_id'); // const
			$table->string('name', 128)->nullable();
            $table->string('code', 64)->nullable();
			$table->unsignedInteger('num')->nullable();
			$table->string('description', 256);
			$table->unsignedInteger('start_at')->nullable();
			$table->unsignedInteger('end_at')->nullable();
			
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
			
            /*$table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();*/
        });
        // unique site in each study
		// site study specific (subjects are grouped by site)
        Schema::create('study_sites', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('study_id'); // ForeignKey
            $table->string('code', 64)->nullable();
			$table->string('name', 128)->nullable();
            $table->string('department', 128)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('city', 64)->nullable();
			$table->string('state', 64)->nullable();
            $table->string('country', 64)->nullable();
			$table->unsignedInteger('country_id')->nullable();
			$table->string('tz', 64)->nullable();
			$table->string('contact', 64)->nullable();
			$table->string('phone', 64)->nullable();
			$table->string('email', 128)->nullable();
			
			$table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable(); //user_id
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable(); // user_id
			
            /*$table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();*/
        });
		// Security profiles are defined at sponsor level and assigned 
        // to  user's per study.
        // Allows user to have different profiles per study.
        // Investigators, reviewers, monitors etc.
        Schema::create('study_user_profiles', function (Blueprint $table) {
            $table->increments('id');//$table->id();
			$table->unsignedInteger('user_id');
            $table->unsignedInteger('study_id');
			// Actions controlled by Security profile
            // actions: =>['full'=>0, 'read-only'=> 1, 'read-write'=>1,'delete'=>1],
            $table->unsignedInteger('sponsor_profile_id');
            // Access to resources within study.
            // Empty policy means allow all. either allow or deny should 
            // be populated.
            // resource = ['site' => [
            //                  'allow'=>[SITE-ID1, SITE-ID2, SITE-ID3...],
            //                  'deny'=>[SITE-ID1, SITE-ID2, SITE-ID3...],
            //             'subject'=>[SUB-ID1, SUB-ID2, SUB-ID3...],
            //                  'allow'=>[SUB-ID1, SUB-ID2, SUB-ID3...],
            //                  'deny'=>[SUB-ID1, SUB-ID2, SUB-ID3...]],
            //             'visit'=>['date_start'=>'', 'date_end'=>''],
            //            ]
            $table->text('resource')->nullable(); // json

            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            /*$table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();*/
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studies');
        Schema::dropIfExists('study_sites');
        Schema::dropIfExists('study_user_profiles');
    }
}
