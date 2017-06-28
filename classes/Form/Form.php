<?php
namespace Form;

use \Config;
use \Form\Field\HiddenField;

class Form {

    private $fields;
    private $values;

    public function __construct($fields, $values=array()){
        $this->fields = $fields;
        $this->values = $values;
    }

    public function html($withLabel=true){
        return $this->render('html', $withLabel);
    }

    public function as_p($withLabel=true){
        return $this->render('as_p', $withLabel);
    }

    public function as_li($withLabel=true){
        return $this->render('as_li', $withLabel);
    }

    public function fields(){
        return $this->fields;
    }

    public function setValues($values){
        $this->values = $values;
    }

    private function render($renderer, $withLabel){
        $html = '';

        foreach ($this->fields as $field){
            $value = self::getValue($field, $this->values);
            $html .= $field->$renderer($value, $withLabel);
        }
        return $html;
    }

    private static function getValue($field, $values){
        if (isset($values[$field->name])){
            return $values[$field->name];
        }
        return null;
    }
}

