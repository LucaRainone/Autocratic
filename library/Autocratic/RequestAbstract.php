<?php

namespace Autocratic;

use Autocratic\Validator\Item;
use Autocratic\Validator\ItemCollection;

abstract class RequestAbstract {

    protected static $SUPERVAR = 'Overridden';
    protected static $safevar;
    protected static $_instances = array();

    protected $items;

    private function __construct() {
        static::fillSafeVar();
        $this->items = new ItemCollection(static::$safevar);
    }

    public static function safe() {
        static::fillSafeVar();
        unset($GLOBALS[static::$SUPERVAR]);
    }

    /**
     * @param $key
     * @param null $default
     * @return Item
     * @throws Validator\Exception
     */
    public function get($key, $default = null) {
        return isset($this->items[$key])? $this->items->get($key) : new Item($default);
    }

    /**
     * @return $this;
     */
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }

    private static function fillSafeVar() {
        $var = static::$SUPERVAR;
        if(!isset($GLOBALS[$var])) {
            return ;
        }
        static::$safevar = $GLOBALS[$var];
    }


}