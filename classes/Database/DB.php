<?php
namespace Database;

use \mysqli;

class DB {
    private $mysqli;

    public function __construct($host, $user, $password, $dbname){
        $this->mysqli = new mysqli($host, $user, $password, $dbname);

        if ($this->mysqli->connect_errno)
            die($this->mysqli->connect_error);
    }

    public function query($sql){
        $result = $this->mysqli->query($sql);

        return $this->buildResult($result);
    }

    private function action($action, $table, $where=array()){
        $sql = "{$action} FROM {$table}";
        $params = array();

        if (count($where)){
            $sql .= " WHERE ";
            $sql .= self::attributeValueToStr($where, " and ");
        }

        return $this->query($sql);
    }

    public function get($table, $where=array()){
        return $this->action("SELECT * ", $table, $where);
    }

    public function delete($table, $where){
        return $this->action("DELETE", $table, $where);
    }

    public function insert($table, $fields=array()){
        if (!count($fields)){
            return false;
        }

        $keys_str = '`' . implode('`,`', array_keys($fields)) . '`';
        $values_str = '"'. implode('","', array_values($fields)) . '"';

        $sql = "INSERT INTO {$table} ({$keys_str}) VALUES ({$values_str})";
        return $this->query($sql);
    }

    public function update($table, $set, $where){
        if (!count($where) || !count($set)){
            return false;
        }

        $where_str = self::attributeValueToStr($where, ' and ');
        $set_str = self::attributeValueToStr($set);

        $sql = "UPDATE {$table} SET {$set_str} WHERE {$where_str}";
        
        return $this->query($sql);
    }

    // =========================== Helping functions ===========================
    private function buildResult($result){
        if ($result === false)      // Errore durante la query
            return new DBResult(null, 0,
                                $this->mysqli->errno, $this->mysqli->error);
        if ($result === true)       // Query con successo ma senza result set
            return new DBResult(null, 0);

        // Query con successo e con result set
        $count = $result->num_rows;
        $rows = array();
        
        while ($row = $result->fetch_object()){
            $rows[] = $row;
        }
        return new DBResult($rows, $count);
    }

    private static function attributeValueToStr($fields, $glue=','){
        $str = "";
        $i = 0;
        foreach ($fields as $field => $value){            
            $str .= "{$field}=\"{$value}\"";

            if (++$i< count($fields))
                $str .= "{$glue}";
        }

        return $str;
    }
}