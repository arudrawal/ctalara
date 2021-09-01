<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// Study status: constants
// mimic table: study_status 
class StudyStatus {
    const DEVELOPMENT=1;
    const ACTIVE = 2;
    const COMPLETED = 3;
    const TERMINATED = 4;
    const STUDY_STATUS = [
        ['id'=>self::DEVELOPMENT, 'name'=>'Development','description'=>'Initial state'],
        ['id'=>self::ACTIVE, 'name'=>'Active','description'=>'Study in progress'],
        ['id'=>self::COMPLETED, 'name'=>'Completed','description'=>'Completed'],
        ['id'=>self::TERMINATED, 'name'=>'Terminated','description'=>'Ended without completion'],
    ];
    // return as collection
    public static function all() {
        return collect(self::STUDY_STATUS);
    }
}
