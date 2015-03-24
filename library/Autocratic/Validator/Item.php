<?php

namespace Autocratic\Validator;

use Autocratic\Validator\Type\TypeInterface;

class Item implements ItemInterface {

    protected $value;
    /**
     * @var TypeInterface
     */
    protected $instanceOfType;

    public function __construct($value) {
        $this->value = $value;
    }

    public function mustBe() {
        $args = func_get_args();
        $typesName = array();
        foreach($args as $type) {
            if(is_string($type)) {
                if (!class_exists($type)) {
                    throw new Exception(sprintf("Class %s not exists", $type));
                }
                $typesName[] = $type;
                /**
                 * @var TypeInterface $item
                 */
                $item = new $type();
                $item->set($this->value);
                if (!($item instanceof TypeInterface)) {
                    throw new Exception(sprintf("$type must be an instance of %s", __NAMESPACE__ . '\TypeInterface'));
                }
            }else if(($type instanceof TypeInterface)){
                $typesName[] = get_class($type);
                $item = $type;
                $item->set($this->value);
            }else {
                throw new Exception(sprintf("$type must be an instance of %s", __NAMESPACE__ . '\TypeInterface'));
            }

            if($item->check()) {
                $this->instanceOfType = $item;
                return $this->sanitize();
            }
        }

        $exception = new Exception(sprintf("Input `%s` is not a valid type (`%s`)",print_r($this->value,true), implode("`,`",$typesName)));
        $exception->setInfo(array(
            'value' => print_r($this->value, true),
            'allowedTypes' => $typesName
        ));
        throw $exception;
    }

    public function sanitize() {
        return $this->instanceOfType->get();
    }
}