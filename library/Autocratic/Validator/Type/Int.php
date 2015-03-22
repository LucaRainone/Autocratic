<?php

namespace Autocratic\Validator\Type;

class Int extends TypeAbstract {

    const NAME = '\Autocratic\Validator\Type\Int';
    protected $value;

    public function check() {
        return is_numeric($this->value) && is_int(($this->value + 0));
    }

    public function get(){
        return (int)$this->value;
    }

    public function set($value) {
        $this->value = $value;
    }
}