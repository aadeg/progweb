<?php
namespace Database;

class DBResult {
    
    private $rows;
    private $count;
    private $errno;
    private $error;
    private $lastId;

    public function __construct($rows, $count, $errno=0, $error='',
				$lastId=null){
        $this->rows = $rows;
        $this->count = $count;
        $this->errno = $errno;
        $this->error = $error;
	$this->lastId = $lastId;
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

    public function lastId(){
	return $this->lastId;
    }

    public function setLastId($id){
	$this->lastId = $id;
    }
}
