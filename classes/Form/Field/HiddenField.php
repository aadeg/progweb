<?php
namespace Form\Field;

class HiddenField extends BaseInputField {

    const INPUT_TYPE = 'hidden';

    public function __construct($name, $moreAttribs=array()){
        parent::__construct(self::INPUT_TYPE, $name, null, $moreAttribs);
    }

    public function html($value, $withLabel=false){
        return parent::html($value, false);
    }

}
