<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// mimic table: secure activities are performed on secure resources.
// 
class SecureModel {
    const MODEL_NA = 0;
    // Sponsor Level functions
    // sponsor admin can't add/delete sponsor, but allowed all 
    // operations on contacts languages, countires, reuse
    // same permissions.
    const SPONSOR = 1;
    const PROTOCOL = 2;
    const STUDY = 3;
    // Funcions study level and below 
    const SITE = 4;
    const SUBJECT=5;
    const SUBJECT_VISIT=5;
    const SUBJECT_FORM_DATA=7;
    const SUBJECT_FORM_MEDIA=8;
    const SUBJECT_FORM_QUERY=9;
    const SUBJECT_FORM_REPLY=10;
    const SUBJECT_FORM_AUDIT=11;  // view form changes history
    const SUBJECT_FORM_REVIEW=12; // review form data for accuracy, asks question, mark reviewed
    const SUBJECT_FORM_MONITOR=13;// check forms for completion/mark completion

    // each activity has common CRUD actions - stored as json-array. 
    // Additional possible actions like: media-recording - can be avoided.
    const SECURE_MODEL_NA = ['name'=>'N/A','description'=>'N/A'];

    const SECURE_MODEL = [
        self::SPONSOR => ['name'=>'Sponsor','description'=>'Sponsor info'],
        self::PROTOCOL => ['name'=>'Protocol','description'=>'Protocol'],
        self::STUDY => ['name'=>'Study','description'=>'Study'],
        self::SITE =>  ['name'=>'Site','description'=>'Site'],
        self::SUBJECT => ['name'=>'Subject','description'=>'Subject'],
        self::SUBJECT_VISIT => ['name'=>'Visit','description'=>'Subject Visits'],
        self::SUBJECT_FORM_DATA => ['name'=>'Form','description'=>'Form filling/updates'],
        self::SUBJECT_FORM_MEDIA => ['name'=>'Form Media','description'=>'Form audio'],
        self::SUBJECT_FORM_QUERY => ['name'=>'Form Query','description'=>'Ask questions'],
        self::SUBJECT_FORM_REPLY => ['name'=>'Form Reply','description'=>'Reply for questions'],
        self::SUBJECT_FORM_AUDIT => ['name'=>'Audit Logs','description'=>'View Audit'],
        self::SUBJECT_FORM_REVIEW =>['name'=>'Review','description'=>'Review forms for accuracy'],
        self::SUBJECT_FORM_MONITOR => ['name'=>'Monitor','description'=>'Check form for completion'],
    ];
    // Labels for actions as displayed
    public static function actions() {
        return collect(["view"=>0, "update"=>0, "delete"=> 0]);
    }
    // return as collection of activities
    public static function all() {
        return self::SECURE_MODEL;
    }
    public static function getById($id) {
        if (array_key_exists($id, self::SECURE_MODEL)) {
            return self::SECURE_MODEL[$id];
        }
        return self::SECURE_MODEL_NA;
    }
}
