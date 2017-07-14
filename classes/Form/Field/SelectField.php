<?php
namespace Form\Field;

class SelectField extends BaseField {
    const TAG = 'select';
    const OPTION_TAG = 'option';

    public $choices;

    public function __construct($name, $label, $choices, $moreAttribs=array()){
        parent::__construct($name, $label, $moreAttribs);
        $this->choices = $choices;
    }

    public function html($selectedValue=null, $withLabel=true){
        $attribs = self::implodeAttributes($this->getAttributes());
        $options = "";

        foreach ($this->choices as $value => $text){
            $selected = ($value == $selectedValue) ? " selected" : "";
            $options .= "<option value=\"{$value}\"{$selected}>$text</option>";
        }

        return "<select {$attribs}>{$options}</select>";
    }


}