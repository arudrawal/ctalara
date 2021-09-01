<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// Available forms: implemented by application
// mimic table: cta_forms,  pre-requiites (protocol specific)
// deleted_at: for obsoleted forms. New version could obsolete old form.
class AdminForm {
    const NA = 0;
    const MINI = 1;
    const PANSS = 2;
    const CSSRS = 3;
    const CGI = 4;
    const CDSS = 5;
    const NSA = 6;
    const RANDOMIZE = 7;
    const CLOSURE = 8;
    const FORM_NA = ['id'=>self::NA, 'name'=>'N/A','description'=>'Not/Available', 
                    'media'=> 0, 'version'=> 1, "parent_id"=>0, "deleted_at" =>0];
    const FORMS = [
        self::MINI => ['id'=>self::MINI, 'name'=>'MINI','description'=>'DSM-V as aided by MINI', 
                        'media'=> 1, 'version'=> 1, "parent_id"=>0, "deleted_at" =>0],
        self::PANSS => ['id'=>self::PANSS, 'name'=>'PANSS', 'description'=>'PANSS (administered as PANSS-SCI)',
                        'media'=>0, 'version'=> 1,"parent_id"=>0, "deleted_at" =>0],
        self::CSSRS => ['id'=>self::CSSRS, 'name'=>'C-SSRS', 'description'=>'C-SSRS','media'=>0, 
                        'version'=> 1, 'parent_id'=>0, 'deleted_at' =>0],
        self::CGI => ['id'=>self::CGI, 'name'=>'CGI', 'description'=>'CGI-S','media'=>0, 
                        'version'=> 1, 'parent_id'=>0, 'deleted_at' => 0],
        self::CDSS => ['id'=>self::CDSS, 'name'=>'CDSS', 'description'=>'CDSS','media'=>0, 
                        'version'=> 1, "parent_id"=>0, "deleted_at" =>0],
        self::NSA => ['id'=>self::NSA, 'name'=>'NSA', 'description'=>'NSA','media'=>0, 
                        'version'=> 1, "parent_id"=>0, "deleted_at" =>0],
        self::RANDOMIZE => ['id'=>self::RANDOMIZE, 'name'=>'Randomization', 'description'=>'Randomization','media'=>0, 
                        'version'=> 1, "parent_id"=>0, "deleted_at" =>0],
        self::CLOSURE => ['id'=>self::CLOSURE, 'name'=>'Closure', 'description'=>'Closure','media'=>0, 
                        'version'=> 1, "parent_id"=>0, "deleted_at" =>0],
    ];
    // return as collection
    public static function all() {
        return collect(self::FORMS);
    }
    public static function isValid($id) {
        return ($id > self::NA && $id <= self::CLOSURE) ? true : false;
    }
    public static function getById($id) {
        if ($id >= self::MINI && $id <= self::CLOSURE) {
            return self::FORMS[$id];
        }
        return self::FORM_NA;
    }
}