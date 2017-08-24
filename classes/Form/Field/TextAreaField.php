<?php
namespace Form\Field;

class TextAreaField extends BaseField {
    const TAG = 'textarea';

    public function __construct($name, $label, $moreAttribs=array()){
        parent::__construct($name, $label, $moreAttribs);
    }

    public function html($value=null, $withLabel=true){
        if ($value === null){
            $value = '';
        }

        $attribs = self::implodeAttributes($this->getAttributes());
        
        $html = "<textarea {$attribs}>{$value}</textarea>";

        if ($withLabel)
            $html = "<label>{$this->label} {$html}</label>";

        return $html;
    }

    public function getAttributes(){
        $attribs = parent::getAttributes();
        $attribs["id"] = $this->name;
        return $attribs;
    }
}
