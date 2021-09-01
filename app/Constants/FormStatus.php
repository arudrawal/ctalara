<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// Forms status: constants
// mimic table: cta_form_status 
class FormStatus {
    const EMPTY = 1;
    const INCOMPLETE = 2;
    const AUDIT_FIALED = 3; // automatic software check
    const REVIEW_PENDING = 4; // basic audit passed
    const QUERY_PENDING = 5; // reviewer raised query
    const REVIEW_BYPASSED = 6; // review not required
    const INCONCLUSIVE = 7; // Review can't be completed, missing info
    const REJECTED = 8;
    const APPROVED = 9;
    
    const FORM_STATUS = [
        self::EMPTY => ['id'=>self::EMPTY, 'name'=>'Empty','description'=>'Form is empty, scheduled to be filled in future'],
        self::INCOMPLETE => ['id'=>self::INCOMPLETE, 'name'=>'Incomplete','description'=>'Partially filled, not completed'],
        self::AUDIT_FIALED => ['id'=>self::AUDIT_FIALED, 'name'=>'Audit Failed','description'=>'Audit checks failed'],
        self::REVIEW_PENDING => ['id'=>self::REVIEW_PENDING, 'name'=>'Review Pending','description'=>'Review Pending'],
        self::QUERY_PENDING => ['id'=>self::QUERY_PENDING, 'name'=>'Query Pending','description'=>'Query by reviewer not answered'],
        self::REVIEW_BYPASSED => ['id'=>self::REVIEW_BYPASSED, 'name'=>'Review Bypassed','description'=>'Approved review bypassed'],
        self::INCONCLUSIVE => ['id'=>self::INCONCLUSIVE, 'name'=>'Inconclusive','description'=>'Reviewer could not reach on any conclusion'],
        self::REJECTED => ['id'=>self::REJECTED, 'name'=>'Rejected','description'=>'Reviewer rejected the data'],
        self::APPROVED => ['id'=>self::APPROVED, 'name'=>'Approved','description'=>'Reviewer approved the data'],
    ];
    // return as collection
    public static function all() {
        return collect(self::FORM_STATUS);
    }
}
