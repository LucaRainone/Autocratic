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
        foreach($args as $type) {
            if(is_string($type)) {
                if (!class_exists($type)) {
                    throw new Exception(sprintf("Class %s not exists", $type));
                }
                /**
                 * @var TypeInterface $item
                 */
                $item = new $type();
                $item->set($this->value);
                if (!($item instanceof TypeInterface)) {
                    throw new Exception(sprintf("$type must be an instance of %s", __NAMESPACE__ . '\TypeInterface'));
                }
            }else if(($type instanceof TypeInterface)){
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

        throw new Exception(sprintf("Input of type `%s` is not a valid type",gettype($this->value)));
    }

    public function sanitize() {
        return $this->instanceOfType->get();
    }
}