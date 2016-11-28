<?php

class Redirect {
    
    public static function to($location){
        header("Location: {$location}");
        exit();
    }

    public static function error($err_code){
        http_response_code($err_code);
        exit();
    }
}