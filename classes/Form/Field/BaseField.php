<?php
namespace Form\Field;

class BaseField {

    public $name;
    public $label;
    public $moreAttribs;

    protected function __construct($name, $label, $moreAttribs=array()){
        $this->name = $name;
        $this->label = $label;
        $this->moreAttribs = $moreAttribs;
    }

    public function getAttributes(){
        $attribs = array(
            "name" => $this->name
        );
        $attribs += $this->moreAttribs;
        // Rimozione degli attributi con valure null
        return self::filterAttributes($attribs);
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
    
    public function as_li($value=null, $withLabel=true){
        $label = "<label for='{$this->name}'>{$this->label}</label>";
        return "<li>{$label}" . $this->html($value, false) . "</li>\n";
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
            $str .= "{$key}=\"{$value}\"";
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