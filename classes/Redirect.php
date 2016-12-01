<?php

class Redirect {
    
    public static function to($location, $queryData=array()){
        $query = "";
        if (count($queryData))
            $query = "?" . http_build_query($queryData);
        header("Location: {$location}{$query}");
        exit();
    }

    public static function error($err_code){
        http_response_code($err_code);
        exit();
    }
}