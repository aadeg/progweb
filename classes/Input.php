<?php

class Input {
    public static function isSubmit($method='POST'){
        $method = strtoupper($method);
        $source = self::getSource($method);

        return $_SERVER['REQUEST_METHOD'] == $method && !empty($source);
    }

    public static function get($item){
        $method = $_SERVER['REQUEST_METHOD'];
        $source = self::getSource($method);

        if(isset($source[$item])){
            return $source[$item];
        }
        return '';
    }

    public static function getAll(){
        $method = $_SERVER['REQUEST_METHOD'];
        $source = self::getSource($method);
        if (!$source)
            return array();
        return $source;
    }

    private static function &getSource($method){
        if ($method == 'POST'){
            return $_POST;
        } elseif ($method == 'GET') {
            return $_GET;
        }
        return false;    
    }
}