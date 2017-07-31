<?php

class Session {

    const FLASH_MESSAGES = 'session.flash_messages';

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
        return null;
    }

    public static function flash($msg, $level=null){
        if (self::exists(Config::get(self::FLASH_MESSAGES)))
            $msgs = self::get(Config::get(self::FLASH_MESSAGES));
        else
            $msgs = array();
        
        $msgs[] = array("msg" => $msg, "level" => $level);
        self::put(Config::get(self::FLASH_MESSAGES), $msgs);
    }

    public static function flashMessages(){
        $msgs = self::get(Config::get(self::FLASH_MESSAGES));
        if ($msgs === null)
            $msgs = array();
        else
            self::delete(Config::get(self::FLASH_MESSAGES));
        return $msgs;
    }
        
}
