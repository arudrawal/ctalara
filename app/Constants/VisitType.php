<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// mimic table: visit_types
class VisitType {
    const NA = 0;
    const PROTOCOL = 1;
    const UNPLANNED = 2;
    const CLOSURE = 3;

    const VISIT_TYPE = [
        self::NA => ['id'=>0, 'name'=>'NA','description'=>'NA'],
        self::PROTOCOL => ['id'=>self::PROTOCOL, 'name'=>'Protocol','description'=>'Visit planned by study protocol'],
        self::UNPLANNED => ['id'=>self::UNPLANNED, 'name'=>'Unplanned','description'=>'Unplanned (emergency) visit'],
        self::CLOSURE => ['id'=>self::CLOSURE, 'name'=>'Closure','description'=>'Subject Closure'],
    ];
    // return as collection
    public static function all() {
        return collect(self::VISIT_TYPE);
    }
    public static function getById($id) {
        if ($id <= self::CLOSURE) {
            return self::VISIT_TYPE[$id];
        }
        return self::VISIT_TYPE[0];
    }
}
