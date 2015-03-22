<?php

namespace AutocraticTest\Validator\Type;

use Autocratic\Validator\Type\DateString;

class DateStringTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider successCasesProvider
     * @param mixed $val
     */
    public function testSuccess($val) {
        $type = new DateString();
        $type->set($val);
        $this->assertTrue($type->check());
    }

    public function successCasesProvider() {
        return array(
            array("2014-02-10"),
            array("2015-02-12"),
            array("1969-02-15"),
            array("2560-02-15"),
        );
    }

    /**
     * @dataProvider failsCasesProvider
     * @param mixed $val
     */
    public function testFails($val) {
        $type = new DateString();
        $type->set($val);
        $this->assertFalse($type->check());
    }

    public function failsCasesProvider() {
        return array(
            array(123234),
            array("123234"),
            array("2014-02-30"),
            array("2015-13-04"),
            array("2015-3-04"),
            array("2015-3-4"),
            array("15-3-4"),
        );
    }

    /**
     * @dataProvider successCasesMinProvider
     * @param $min
     * @param $val
     */
    public function testMinSuccess($min, $val) {
        $type = new DateString($min);
        $type->set($val);
        $this->assertTrue($type->check());
    }

    public function successCasesMinProvider() {
        return array(
            array('now', date("Y-m-d",strtotime("now"))),
            array('now', date("Y-m-d",strtotime("now + 1 weeks"))),
            array('now', date("Y-m-d",strtotime("now + 10 years"))),
            array('tomorrow', date("Y-m-d",strtotime("now + 2 days"))),
        );
    }

    /**
     * @dataProvider failsCasesMinProvider
     * @param $min
     * @param $val
     */
    public function testMinFails($min, $val) {
        $type = new DateString($min);
        $type->set($val);
        $this->assertFalse($type->check());
    }

    public function failsCasesMinProvider() {
        return array(
            array('now', date("Y-m-d",strtotime("now - 1 days"))),
            array('now', date("Y-m-d",strtotime("now - 1 weeks"))),
            array('now', date("Y-m-d",strtotime("now - 10 years"))),
            array('tomorrow', date("Y-m-d",strtotime("now"))),
        );
    }


    /**
     * @dataProvider successCasesMaxProvider
     * @param $min
     * @param $val
     */
    public function testMaxSuccess($min, $val) {
        $type = new DateString($min);
        $type->set($val);
        $this->assertFalse($type->check());
    }

    public function successCasesMaxProvider() {
        return array(
            array('now', date("Y-m-d",strtotime("now - 1 days"))),
            array('now', date("Y-m-d",strtotime("now - 1 weeks"))),
            array('now', date("Y-m-d",strtotime("now - 10 years"))),
            array('tomorrow', date("Y-m-d",strtotime("now"))),
        );
    }

    /**
     * @dataProvider failsCasesMaxProvider
     * @param $min
     * @param $val
     */
    public function testMaxFails($min, $val) {
        $type = new DateString($min);
        $type->set($val);
        $this->assertTrue($type->check());
    }

    public function failsCasesMaxProvider() {
        return array(
            array('now', date("Y-m-d",strtotime("now"))),
            array('now', date("Y-m-d",strtotime("now + 1 weeks"))),
            array('now', date("Y-m-d",strtotime("now + 10 years"))),
            array('tomorrow', date("Y-m-d",strtotime("now + 2 days"))),
        );
    }

    /**
     * @dataProvider successCasesMinMaxProvider
     * @param $min
     * @param $max
     * @param $val
     */
    public function testMinMaxSuccess($min, $max, $val) {
        $type = new DateString($min,$max);
        $type->set($val);
        $this->assertTrue($type->check());
    }

    public function successCasesMinMaxProvider() {
        return array(
            array('now', 'now+1week', date("Y-m-d", strtotime("now"))),
            array('now', 'now+1week', date("Y-m-d", strtotime("now+3days"))),
            array('now', 'now+1week', date("Y-m-d", strtotime("now+2days"))),
            array('now', 'now+1week', date("Y-m-d", strtotime("now+1 week"))),
            array('now', 'now+1week', date("Y-m-d", strtotime("now+1day"))),
        );
    }
}