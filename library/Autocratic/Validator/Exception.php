<?php

namespace Autocratic\Validator;

class Exception extends \Exception {

    protected $info = array();

    public function setInfo($info) {
        $this->info = $info;
    }

    public function getInfo() {
        return $this->info;
    }
}