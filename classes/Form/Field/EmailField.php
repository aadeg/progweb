<?php
namespace Form\Field;

class EmailField extends BaseInputField {
    const INPUT_TYPE = 'email';

    public function __construct($name, $label, $moreAttribs=array()){
        parent::__construct(self::INPUT_TYPE, $name, $label, $moreAttribs);
    }
}