<?php

namespace Autocratic\Validator\Type;

class DateString extends TypeAbstract {

    const NAME = '\Autocratic\Validator\Type\DateString';
    protected $value;
    protected $dateMin;
    protected $dateMax;

    public function __construct($dateMin = null, $dateMax = null) {
        $this->dateMin = !is_null($dateMin)? date("Y-m-d",strtotime($dateMin)) : null;
        $this->dateMax = !is_null($dateMax)? date("Y-m-d",strtotime($dateMax)) : null;
    }

    public function check() {
        $date = $this->value;
        // http://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        $isValid = $d && $d->format('Y-m-d') == $date;
        if($isValid) {
            if(!is_null($this->dateMin)) {
                $isValid = $d->format('Y-m-d') >= $this->dateMin;
            }
            if(!is_null($this->dateMax)) {
                $isValid = $d->format('Y-m-d') <= $this->dateMax;
            }
        }
        return $isValid;
    }

    public function get(){
        return (string)$this->value;
    }

    public function set($value) {
        $this->value = $value;
    }
}