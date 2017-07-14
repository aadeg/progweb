<?php

namespace Model;

class BaseModel {

    protected static $db;

    public static function setDatabase($db){
        self::$db = $db;
    }

}