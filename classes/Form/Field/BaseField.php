<?php
namespace Form\Field;

class BaseField {

    protected function __construct(){

    }

    public function html($value=null, $withLabel=true){
        return "";
    }

    public function as_p($value=null, $withLabel=true){
        return "";
    }

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

    /*
    protected static function addAttributeIfSet(&$array, $attrib, $value){
        if ($value == null || $value == "")
            return;

        $array[$attrib] = $value;
    }
    */

    protected static function filterAttributes($attribs){
        return array_filter($attribs, function($val){ return $val !== null; });
    }
}