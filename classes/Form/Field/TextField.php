<?php
namespace Form\Field;

class TextField extends BaseInputField {
    const INPUT_TYPE = 'text';

    public function __construct($name, $label, $moreAttribs=array()){
        parent::__construct(self::INPUT_TYPE, $name, $label, $moreAttribs);
    }
}