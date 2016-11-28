<?php
namespace Form\Field;

class BaseInputField extends BaseField{
    const TAG = 'input';

    private $type;
    public $name;
    public $moreAttribs;

    public $label;

    protected $attributes;

    public function __construct($type, $name, $label, $moreAttribs=array()){
        $this->type = $type;
        $this->name = $name;
        $this->moreAttribs = $moreAttribs;

        $this->attributes = $this->attributes();

        $this->label = $label;
    }

    public function html($value=null, $withLabel=true){
        if ($value === null){
            $value = '';
        }

        $attribs = $this->attributesStr();
        
        $value_str = "";
        if ($value != ''){
            $value_str = " value={$value}";
        }
        
        $html = "<input {$attribs}{$value_str}>";

        if ($withLabel){
            $html = "<label>{$this->label} {$html}</label>";
        }
        return $html;
    }

    public function as_p($value=null, $withLabel=true){
        return "<p>" . $this->html($value, $withLabel) . "</p>\n";
    }

    public function attributes(){
        $attribs = array(
            "type" =>           $this->type,
            "name" =>           $this->name
        );

        $attribs += $this->moreAttribs;

        // Rimozione degli attributi con valure null
        return self::filterAttributes($attribs);
    }

    public function attributesStr(){
        return self::implodeAttributes($this->attributes);
    }
}