<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// Forms status: constants
// mimic table: cta_form_status 
class SubjectStatus {
    const SUBJECT_STATUS = [
        ['id'=>0, 'name'=>'N/A','description'=>'Not applicable'],
        ['id'=>1, 'name'=>'Screening','description'=>'Form is empty, scheduled to be filled in future'],
        ['id'=>2, 'name'=>'Randomized','description'=>'Partially filled, not completed'],
        ['id'=>3, 'name'=>'Completed','description'=>'Audit checks failed'],
        ['id'=>4, 'name'=>'ScreenFailed','description'=>'Review Pending'],
        ['id'=>5, 'name'=>'Study Terminated','description'=>'Query by reviewer not answered'],
        ['id'=>6, 'name'=>'ET NoFollowup','description'=>'Early Termination no followup'],
        ['id'=>7, 'name'=>'ET ConsentWidrawal','description'=>'Early Termination Widrawal with consent'],
        ['id'=>8, 'name'=>'ET AE','description'=>'Early Termination Adverse Event'],
        ['id'=>9, 'name'=>'ET SAE','description'=>'Early Termination Sevier Adverse Event'],
        ['id'=>10, 'name'=>'ET INV-DECISION','description'=>'Early Termination Investigator decision'],
        ['id'=>11, 'name'=>'ET Death','description'=>'Early Termination due to death'],
        ['id'=>11, 'name'=>'ET Pregnancy','description'=>'Early Termination due to pregnancy'],
    ];
    // return as collection
    public static function all() {
        return collect(self::SUBJECT_STATUS);
    }
}
