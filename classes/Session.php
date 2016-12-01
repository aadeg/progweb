<?php

class Session {
    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function exists($key){
        return isset($_SESSION[$key]);
    }

    public static function get($key){
        if (self::exists($key))
            return $_SESSION[$key];
        return null;
    }

    public static function delete($key){
        unset($_SESSION[$key]);
    }

    public static function start(){
        session_start();
    }

    public static function end(){
    }
}