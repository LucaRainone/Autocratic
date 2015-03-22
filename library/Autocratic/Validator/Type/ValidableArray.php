<?php

namespace Autocratic\Validator\Type;

use Autocratic\Validator\ItemCollection;

class ValidableArray extends TypeAbstract {

    const NAME = '\Autocratic\Validator\Type\ValidableArray';
    protected $value;

    public function check() {
        return is_array($this->value);
    }

    public function get(){
        return new ItemCollection($this->value);
    }

    public function set($value) {
        $this->value = $value;
    }
}