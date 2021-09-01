<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {	
        // Monitor review form for completeness - not content.
		Schema::create('form_monitor', function (Blueprint $table) {
            $table->increments('id');//$table->id();
            $table->uuid('uuid');
			$table->unsignedInteger('subject_visit_form_id');
            $table->uuid('subject_visit_form_uuid');
			$table->text('monitor_status')->nullable();
			
			// version controll		
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
			
            $table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
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
        Schema::dropIfExists('form_monitor');
    }
}
