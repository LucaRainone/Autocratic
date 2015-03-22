<?php

namespace Autocratic\Validator\Type;

class ArrayOfInt extends TypeAbstract {

    const NAME = '\Autocratic\Validator\Type\ArrayOfInt';
    protected $value;
    protected $sanitized;
    public function check() {
        if(is_array($this->value)) {
            $sanitized = array();
            foreach($this->value as $k=>$v) {
                $int = new Int();
                $int->set($v);
                if($int->check()) {
                    $sanitized[$k] = $int->get();
                }else {
                    return false;
                }
            }
            $this->sanitized = $sanitized;
            return true;
        }
        return false;
    }

    public function get(){
        if(is_null($this->sanitized)) {
            return null;
        }
        return $this->sanitized;
    }

    public function set($value) {
        $this->value = $value;
    }
}