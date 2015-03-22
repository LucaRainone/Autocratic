<?php

namespace AutocraticTest\Validator\Type;

use Autocratic\Validator\Type\Int;

class IntTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider successCasesProvider
     * @param mixed $val
     */
    public function testSimpleSuccess($val) {
        $type = new Int();
        $type->set($val);
        $this->assertTrue($type->check());
    }

    public function successCasesProvider() {
        return array(
            array(1),
            array(10),
            array(+10),
            array("10"),
            array("-10"),
            array(-10),
            array(0x0A),
            array("0x0A"),
        );
    }

    /**
     * @dataProvider failsCasesProvider
     * @param mixed $val
     */
    public function testFails($val) {
        $type = new Int();
        $type->set($val);
        $this->assertFalse($type->check());
    }


    public function failsCasesProvider() {
        return array(
            array(1.2),
            array(1.0),
            array(4.0),
            array("1.0"),
            array("asdf"),
            array("-1.2"),
            array("-1.2f"),
            array("infinite"),
            array("-infinite"),
        );
    }
}