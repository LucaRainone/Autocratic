<?php

use Autocratic\Get;
use Autocratic\Validator\Type\ArrayOfInt;
use Autocratic\Validator\Type\Int;
use Autocratic\Validator\Type\String;
use Autocratic\Validator\Type\ValidableArray;

require_once '../../AutocraticAutoloader.php';

Get::safe();

$get = Get::getInstance();

try {
    $id = $get->get('id', 12)->mustBe(Int::NAME, String::NAME);
    echo "\$id=$id";

}catch (\Autocratic\Validator\Exception $e) {
    echo $e->getMessage();
    exit;
}


try {
    $ids = $get->get('ids', array(1,2,3,4))->mustBe(ValidableArray::NAME);

    $output = array();
    foreach($ids as $id) {
        /**
         * @var $id \Autocratic\Validator\Item
         */
        $output[] = $id->mustBe(Int::NAME);
    }
    echo "ids=". implode(",",$output);

}catch (\Autocratic\Validator\Exception $e) {
    echo $e->getMessage();
    exit;
}


try {
    $ids = $get->get('ids', array(12,3,4,5))->mustBe(ArrayOfInt::NAME);

    echo "ids=". implode(",",$ids);

}catch (\Autocratic\Validator\Exception $e) {
    echo $e->getMessage();
    exit;
}

