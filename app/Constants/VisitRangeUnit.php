<?php
namespace App\Constants;

use Illuminate\Support\Collection;
// mimic table: visit_types
class VisitRangeUnit {
    const DAY = 1;
    const WEEK = 2;
    const MONTH = 3;
    const YEAR = 4;

    const VISIT_RANGE_UNIT = [
        self::DAY => ['id'=>self::DAY, 'name'=>'Day','description'=>'start/end range in days'],
        self::WEEK => ['id'=>self::WEEK, 'name'=>'Week','description'=>'start/end range in weeks'],
        self::MONTH => ['id'=>self::MONTH, 'name'=>'Month','description'=>'start/end range in months'],
        self::YEAR => ['id'=>self::YEAR, 'name'=>'Year','description'=>'start/end range in years'],
    ];
    // return as collection
    public static function all() {
        return collect(self::VISIT_RANGE_UNIT);
    }
    public static function getById($id) {
        if ($id <= self::YEAR) {
            return self::VISIT_RANGE_UNIT[$id];
        }
        return self::VISIT_RANGE_UNIT[0];
    }
}
