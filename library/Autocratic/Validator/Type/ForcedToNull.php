<?php

namespace Autocratic\Validator\Type;

class ForcedToNull extends TypeAbstract {

    const NAME = '\Autocratic\Validator\Type\ForcedToNull';
    protected $value;

    public function check() {
        return true;
    }

    public function get(){
        return null;
    }

    public function set($value) {
        $this->value = $value;
    }
}