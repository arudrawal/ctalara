<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Constants\CtaForm;
use App\Constants\SecureActivity;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        //var_dump(CtaForm::FORMS[0]);
        //$forms = CtaForm::all();
        //$forms->dd(); // dump()
        //$forms->each(function ($item, $key) {var_dump($item);});
        foreach (SecureActivity::all() as $activity) {
            var_dump($activity['actions']);
        }

        $this->assertTrue(true);
    }
}
