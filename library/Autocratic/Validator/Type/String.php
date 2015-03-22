<?php

namespace Autocratic\Validator\Type;

class String extends TypeAbstract {

    const NAME = '\Autocratic\Validator\Type\String';

    public function check()
    {
        return is_string($this->value);
    }

    public function get()
    {
        return (string)$this->value;
    }

}