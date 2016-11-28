<?php

class DBResult {

    const SQLSTATE_SUCCESS = '00000';

    private $rows;
    private $count;
    private $errorInfo;

    public function __construct($rows, $count, $errorInfo=null){
        $this->rows = $rows;
        $this->count = $count;
        $this->errorInfo = $errorInfo;
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
        return !(isset($this->errorInfo) &&
                 $this->errorInfo[0] == self::SQLSTATE_SUCCESS);
    }

    public function errorInfo(){
        return $this->errorInfo;
    }

    public function errorMsg(){
        if (!isset($this->errorInfo)){
            return null;
        }

        return $this->errorInfo[2];
    }
}