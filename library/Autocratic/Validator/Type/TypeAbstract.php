<?php

namespace Autocratic\Validator\Type;

abstract class TypeAbstract implements TypeInterface {
    const NAME = "";
    protected $value;

    public function set($value) {
        $this->value = $value;
    }
}