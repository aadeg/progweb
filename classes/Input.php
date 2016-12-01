<?php

class Input {
    public static function isSubmit($method='POST'){
        $method = strtoupper($method);
        $source = self::getSource($method);

        return $_SERVER['REQUEST_METHOD'] == $method && !empty($source);
    }

    public static function get($item, $method=null){
        $method = self::getMethod($method);
        $source = self::getSource($method);

        if(!isset($source[$item]))
            return '';
        return $source[$item];
    }

    public static function getAll($method=null){
        $method = self::getMethod($method);
        $source = self::getSource($method);
        
        if (!$source)
            return array();
        return $source;
    }

    private static function getMethod($method){
         if ($method == null)
            return $_SERVER['REQUEST_METHOD'];
        return strtoupper($method);
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