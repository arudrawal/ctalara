<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// Forms status: constants
// mimic table: cta_form_status 
class VisitStatus {
    const SCHEDULED = 1;
    const MISSED = 2;
    const IN_PROGRESS = 3;
    const COMPLETED = 4;
    const VISIT_STATUS = [
        ['id'=>self::SCHEDULED, 'name'=>'Scheduled','description'=>'Visit scheduled in future'],
        ['id'=>self::MISSED, 'name'=>'Missed(past overdue)','description'=>'Visit was scheduled in past, never started'],
        ['id'=>self::IN_PROGRESS, 'name'=>'In progress','description'=>'Started but not marked completed'],
        ['id'=>self::COMPLETE, 'name'=>'Completed','description'=>'Marked Completed'],
    ];
    // return as collection
    public static function all() {
        return collect(self::VISIT_STATUS);
    }
}
