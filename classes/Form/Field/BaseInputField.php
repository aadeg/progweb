<?php
namespace Form\Field;

class BaseInputField extends BaseField{
    const TAG = 'input';

    private $type;

    public function __construct($type, $name, $label, $moreAttribs=array()){
        parent::__construct($name, $label, $moreAttribs);
        $this->type = $type;

        $this->attributes = $this->getAttributes();
    }

    public function html($value=null, $withLabel=true){
        if ($value === null){
            $value = '';
        }

        $attribs = self::implodeAttributes($this->getAttributes());
        
        $value_str = "";
        if ($value != '')
            $value_str = " value=\"{$value}\"";
        
        $html = "<input {$attribs}{$value_str}>";

        if ($withLabel){
            $html = "<label>{$this->label} {$html}</label>";
        }
        return $html;
    }

    public function getAttributes(){
        $attribs = parent::getAttributes();
        $attribs["type"] = $this->type;
        $attribs["id"] = $this->name;
        return $attribs;
    }
}