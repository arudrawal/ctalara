<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// protocols: created for sponsor - at server (for mobile: read-only)
        // updated_at: can be used for sync by mobile client.
        Schema::create('protocols', function (Blueprint $table) {
            $table->increments('id');//$table->id();
			$table->unsignedInteger('sponsor_id'); // Foreign Key
			$table->string('code', 64);
            $table->string('rev', 64);
			$table->string('description', 256)->nullable();
            $table->string('phase', 32)->nullable();
            $table->string('product', 128)->nullable();
			$table->string('drafted_at',64)->nullable();

            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();			
        });
        
        // First visits: set up the time clock for rest of the visits
        Schema::create('protocol_visits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('protocol_id'); // FK
			$table->unsignedInteger('order'); // order of visit
            // type: defined by protocol or emergency(unplanned)
            $table->unsignedInteger('visit_type')->nullable(); // null/zero: protocol defined
			$table->string('name', 128)->nullable(); // screening
			$table->string('description', 256)->nullable(); // first visit
            // visit date/time data based on reference visit.
            // first visit may not have ref, it could be absolute.
            // second visit: 4 days later - plus/minus 1 day is ok.
            //              ref=1, start=3, end=5 unit=days
            //       
			$table->unsignedInteger('ref_visit_id')->nullable();// key in same table
            $table->unsignedInteger('range_start')->nullable();
            $table->unsignedInteger('range_end')->nullable();
            // Time measured by this unit: TS: absolute timestamp
            $table->unsignedInteger('range_unit')->nullable(); // hour|day|week|month|year|TS

			$table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable(); //user_id
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable(); // user_id
        });

        Schema::create('protocol_visit_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visit_id');
            $table->unsignedInteger('form_id');// comes from constants
			$table->unsignedInteger('order');  // display/fill in this order
			$table->unsignedInteger('optional')->nullable();
			
			$table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable(); //user_id
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable(); // user_id			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('protocols');
		Schema::dropIfExists('protocol_visits');
		Schema::dropIfExists('protocol_visit_forms');
    }
}
