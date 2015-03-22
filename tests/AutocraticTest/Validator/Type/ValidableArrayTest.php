<?php

namespace AutocraticTest\Validator\Type;

use Autocratic\Validator\Type\ValidableArray;

class ValidableArrayTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider successCasesProvider
     * @param mixed $val
     */
    public function testSimpleSuccess($val) {
        $type = new ValidableArray();
        $type->set($val);
        $this->assertTrue($type->check());
        $itemCollection = $type->get();
        $this->assertInstanceOf('Autocratic\\Validator\\ItemCollection', $itemCollection);
    }

    public function successCasesProvider() {
        return array(
            array(array("a"=>1)),
            array(array(1,2,3,4,5)),
            array(array(1,2,3,4,4=>"c")),
        );
    }

    /**
     * @dataProvider failsCasesProvider
     * @param mixed $val
     */
    public function testSimpleFails($val) {
        $type = new ValidableArray();
        $type->set($val);
        $this->assertFalse($type->check());
    }

    public function failsCasesProvider() {
        return array(
            array('array("a"=>1)'),
            array(13),
            array(new \StdClass()), // StdClass
        );
    }

}