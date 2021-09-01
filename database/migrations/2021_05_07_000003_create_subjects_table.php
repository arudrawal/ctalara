<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    // We use this for main/history table
    protected function createSubjectColumns ($table) {
        $table->uuid('uuid', 32)->nullable();
        
        $table->unsignedInteger('study_id');
        $table->unsignedInteger('site_id');			

        // code and number
        $table->unsignedInteger('number')->nullable();
        $table->string('code', 64)->nullable();
        
        $table->string('code1', 64)->nullable();
        $table->string('code1_name', 128)->nullable();
        
        $table->string('code2', 64)->nullable();
        $table->string('code2_name', 128)->nullable();
        
        $table->string('initials', 32)->nullable();
        $table->string('gender', 32)->nullable();
        $table->string('dob', 32)->nullable();
        $table->unsignedInteger('enrolled_at')->nullable();
        $table->unsignedInteger('locked_at')->nullable();
        $table->unsignedInteger('subject_status_id')->nullable();
        
        $table->unsignedInteger('created_at')->nullable();
        $table->unsignedInteger('created_by')->nullable(); //user_id
        $table->unsignedInteger('updated_at')->nullable();
        $table->unsignedInteger('updated_by')->nullable(); // user_id
        
        $table->uuid('version_uuid', 32)->nullable();
        $table->string('version_comment')->nullable();
        $table->unsignedInteger('version_at')->nullable();
        $table->string('version_text', 64)->nullable();
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {	
		// unique subjects in each study
		// uuid: columns required if record is created by mobile device.
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $this->createSubjectColumns($table);
        });
        Schema::create('subjects_history', function (Blueprint $table) {
            $table->increments('history_id');
			$table->unsignedInteger('history_created_at')->nullable();
            $table->unsignedInteger('history_created_by')->nullable(); //user_id
			$table->string('history_ip', 128)->nullable(); //remote ip
			
			// subjects record as-is
			$table->unsignedInteger('id');
            $this->createSubjectColumns($table);
        });
        /* Visit can be locked once review is completed by review admin.
        -- visit_lock_ts_gmt=0 - not locked, !=0 GMT when visit is locked.
        -- Once locked - no more changes possible.
        -- visit_status_num - must be calculated summary of Form status
        -- form_status_num - summary of all forms - calculated values
        -- No need to store status values. However good if filled
        -- and returned to UI in JSON format along with the record.
        -- subject_visit_uuid: must be assigned by the device record is added.
        -- subject_visit_num: a serial number calculated by server.
        */
		Schema::create('subject_visits', function (Blueprint $table) {
            // key - for central database
            $table->increments('id');//$table->id();
			$table->uuid('uuid', 32)->nullable(); // mobile key

            $table->unsignedInteger('subject_id');
            $table->uuid('subject_uuid', 32)->nullable();// mobile key
            // visit - sequence(ordering)
            $table->unsignedInteger('order')->nullable(); // order as per protocol
            // sub-order: for emergency visits not part of protocl. Order will match 
            // with one of the protocol visits, sub-order for futrher ordering.
            $table->unsignedInteger('sub_order')->nullable(); 
            // unplanned visits may not exists in protocol
            $table->unsignedInteger('visit_type')->nullable(); // Protocol/Unplanned/Closure etc

            // if conected with protocol defined visit
            $table->unsignedInteger('protocol_visit_id'); // FK

            // Computed from form status
            $table->unsignedInteger('visit_status_id')->nullable(); // const
            $table->unsignedInteger('form_status_id')->nullable();  //const
            
            $table->unsignedInteger('locked_at')->nullable();
            // real visit start/end timestamp
            $table->unsignedInteger('started_at')->nullable();
            $table->unsignedInteger('ended_at')->nullable();
			
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
			
            $table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();
        });
        Schema::create('subject_visit_forms', function (Blueprint $table) {
            // key - for central database
            $table->increments('id');//$table->id();
            $table->uuid('uuid', 32)->nullable(); // mobile key
            
            // unique: subject+visit
            $table->unsignedInteger('subject_id')->nullable();
            $table->uuid('subject_uuid', 32)->nullable();// mobile key

            // this is enough to identify subject 
            $table->unsignedInteger('subject_visit_id');
            $table->uuid('subject_visit_uuid', 32)->nullable();// mobile key


            $table->unsignedInteger('form_id'); // constants
            $table->unsignedInteger('form_status_id')->nullable(); // constant
            // form - sequence(ordering) in the visit
            $table->unsignedInteger('form_order')->nullable(); // from protocol
            $table->unsignedInteger('form_sub_order')->nullable(); // differ for non-protocol forms
            // owner(user): who started filling the form at what time
            // first entry answered and saved.
            $table->unsignedInteger('owner_user_id')->nullable();
            $table->unsignedInteger('owner_user_at')->nullable();
                            
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            
            $table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();
        }); 
        /* Data stored per question basis (one record per question)
            Each question will be reviewed by multiple reviewers
            Review Status in this table is not required, 
            review status can be calculated based on reviewers table
            Leaving this field here for time-being. In any case we must make
            sure that no other than investigator can write to this table.
            Recording markers: if audio/video is recorded,
            we have to record the time offset in the recording
            if no recording is going on still we should record
            when user is clicking which answer compared to start
            time. this will allow us to record some statistics,
            like: how much time a scale usually takes.
            review_status - is unused field.
        */
        Schema::create('subject_form_data', function (Blueprint $table) {
            //$table->unsignedInteger('subject_visit_form_id');
            //$table->uuid('subject_visit_form_uuid', 32)->nullable();
            $table->increments('id');//$table->id();
            $table->uuid('uuid');// key for mobile
            // unique: subject+visit+form (extra info for manual and report querying)
            $table->unsignedInteger('subject_id')->nullable();
            $table->uuid('subject_uuid', 32)->nullable();// mobile key

            // this is enough to identify subject 
            $table->unsignedInteger('subject_visit_id');
            $table->uuid('subject_visit_uuid', 32)->nullable();// mobile key

            $table->unsignedInteger('form_id'); // template id
            $table->unsignedInteger('form_section_id');
            $table->unsignedInteger('form_section_q_id');

            // Allow to over-ride in study
            $table->text('form_data_ans')->nullable();
            $table->text('form_data_note')->nullable();
            $table->text('review_status')->nullable();
            $table->string('media_file_name', 255)->nullable();
            // timestamp when question is saved, if media recording was going on
            // we can establish approx. context.
            $table->unsignedInteger('media_at')->nullable();
                        
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            
            $table->uuid('version_uuid', 32)->nullable();
            $table->string('version_comment')->nullable();
            $table->unsignedInteger('version_at')->nullable();
            $table->string('version_text', 64)->nullable();
        });

        /*
        -- Audio/Video recording for a form. This is optional for some forms
        -- Audio start/end time and date/time of recording are main data to collect
        -- Audio recording is a sure way to tell on what date visit is conducted.
        -- file_uploaded - uploaded to server - used for automatic upload.
        --                 and allow us to control delete/upload actions.
        */
        Schema::create('subject_form_media', function (Blueprint $table) {
            $table->increments('id');//$table->id();
            $table->uuid('uuid');// key for mobile
            // Identifying subject->visit->form key
            $table->unsignedInteger('subject_visit_form_id'); // FK: subject_form_data.id
            $table->uuid('subject_visit_form_uuid', 32)->nullable(); //FK: subject_form_data.uuid

            //// Redudandant info helps in report querying)
                // unique: subject+visit+form 
                $table->unsignedInteger('subject_id')->nullable();
                $table->uuid('subject_uuid', 32)->nullable();// mobile key
                // this is enough to identify subject 
                $table->unsignedInteger('subject_visit_id');
                $table->uuid('subject_visit_uuid', 32)->nullable();// mobile key
                $table->unsignedInteger('form_id'); // template id
            //// End redundant info

            $table->string('media_file_name', 255)->nullable();
            $table->unsignedInteger('media_start_at')->nullable();
            $table->unsignedInteger('media_end_at')->nullable();
            $table->unsignedInteger('media_uploaded_at')->nullable();
            
            // standard
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
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('subjects_history');
        Schema::dropIfExists('subject_visits');
		Schema::dropIfExists('subject_visit_forms');
        Schema::dropIfExists('subject_form_data');
        Schema::dropIfExists('subject_form_media');
    }
}
