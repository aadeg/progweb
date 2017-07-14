<?php
namespace Database;

class DBResult {
    
    private $rows;
    private $count;
    private $errno;
    private $error;

    public function __construct($rows, $count, $errno=0, $error=''){
        $this->rows = $rows;
        $this->count = $count;
        $this->errno = $errno;
        $this->error = $error;
    }

    public function rows(){
        return $this->rows;
    }

    public function count(){
        return $this->count;
    }

    public function first(){
        if ($this->count == 0){
            return null;
        }
        return $this->rows[0];
    }

    public function error(){
        return $this->errno != 0;
    }

    public function errorMsg(){
        return $this->error;
    }
}