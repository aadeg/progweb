<?php
namespace Form\Field;

class BaseField {

    public $name;
    public $label;
    public $moreAttribs;

    protected $attributes;

    protected function __construct($name, $label, $moreAttribs=array()){
        $this->name = $name;
        $this->label = $label;
        $this->moreAttribs = $moreAttribs;

        $this->attributes = $this->getAttributes();    
    }

    public function getAttributes(){
        $attribs = array(
            "name" => $this->name
        );
        $attribs += $this->moreAttribs;
        // Rimozione degli attributi con valure null
        return self::filterAttributes($attribs);
    }

    public function attributesStr(){
        return self::implodeAttributes($this->attributes);
    }

    /*
     * =========================================================================
     *                              Renderers
     * =========================================================================
     */

    public function html($value=null, $withLabel=true){
        return "";
    }

    public function as_p($value=null, $withLabel=true){
        return "<p>" . $this->html($value, $withLabel) . "</p>\n";
    }

    /*
     * =========================================================================
     *                              Static methods
     * =========================================================================
     */
    protected static function implodeAttributes($attributes){
        $str = "";
        $i = 0;
        foreach($attributes as $key => $value){
            $str .= "{$key}='{$value}'";
            if (++$i < count($attributes)){
                $str .= ' ';
            }
        }
        
        return $str;
    }

    protected static function filterAttributes($attribs){
        return array_filter($attribs, function($val){ return $val !== null; });
    }
}