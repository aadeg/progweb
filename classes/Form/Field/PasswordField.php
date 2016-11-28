<?php
namespace Form\Field;

class PasswordField extends BaseInputField {
    const INPUT_TYPE = 'password';

    public function __construct($name, $label, $moreAttribs=array()){
        parent::__construct(self::INPUT_TYPE, $name, $label, $moreAttribs);
    }
    
    public function html($value=null, $withLabel=true){
        // Per motivi di sicurezza, il valore della password non viene
        // passato
        return parent::html(null, $withLabel);
    }
}