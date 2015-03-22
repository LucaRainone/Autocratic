<?php

namespace Autocratic\Validator\Type;

interface TypeInterface {
    public function check();
    public function get();
    public function set($value);
}