<?php

class DB {
    private $pdo;

    public function __construct($host, $username, $password, $dbname){
        try {

            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname",
                                 $username, $password);

        } catch (PDOException $e){
            die($e->getMessage());
        }
    }

    public function query($sql, $params=array(), $fetch=true) {
        $query = $this->pdo->prepare($sql);
        if (!$query){
            return self::buildErrorResult($query);
        }

        // Binding parameters
        if (is_array($params)){
            $i = 1;
            foreach ($params as $param){
                $query->bindValue($i++, $param);
            }
        }

        if(!$query->execute()){
            return self::buildErrorResult($query);
        }

        return self::buildResult($query, $fetch);
    }

    private function action($action, $table, $where=array(), $fetch=true){
        $sql = "{$action} FROM {$table}";
        $params = array();

        if (count($where)){
            $sql .= " WHERE ";
            $sql .= self::attributeValueToStr($where, " and ");
            $params = array_values($where);
        }

        return $this->query($sql, $params, $fetch);
    }

    public function get($table, $where=array()){
        return $this->action("SELECT * ", $table, $where);
    }

    public function delete($table, $where){
        return $this->action("DELETE", $table, $where, false);
    }

    public function insert($table, $fields=array()){
        if (!count($fields)){
            return false;
        }

        $keys_str = "";
        $values_str = "";
        $i = 0;

        // Non uso la funzione implode per scorre una volta sola l'array
        foreach ($fields as $key => $value){
            $keys_str .= "`{$key}`";
            $values_str .= "?";

            if (++$i < count($fields)){
                $keys_str .= ",";
                $values_str .= ",";
            }
        }

        $sql = "INSERT INTO {$table} ({$keys_str}) VALUES ({$values_str})";
        return $this->query($sql, $fields, false);
    }

    public function update($table, $set, $where){
        if (!count($where) || !count($set)){
            return false;
        }

        $where_str = self::attributeValueToStr($where, ' and ');
        $set_str = self::attributeValueToStr($set);

        $sql = "UPDATE {$table} SET {$set_str} WHERE {$where_str}";
        $params = array_merge(array_values($set), array_values($where));
        
        return $this->query($sql, $params, false);
    }

    // =========================== Helping functions ===========================
    private static function buildResult($pdoQuery, $fetch){
        $rows = ($fetch) ? $pdoQuery->fetchAll(PDO::FETCH_OBJ) : null;
        return new DBResult($rows,
                            $pdoQuery->rowCount(),
                            $pdoQuery->errorInfo());
    }

    private static function buildErrorResult($pdoQuery){
        return new DBResult(null, 0, $pdoQuery->errorInfo());
    }

    private static function attributeValueToStr($fields, $glue=',',
                                                $valuePlaceholder='?'){
        $str = "";
        $i = 0;
        foreach ($fields as $field => $value){
            if (!is_null($valuePlaceholder)){
                $value = $valuePlaceholder;
            }
            
            $str .= "{$field}={$value}";

            if (++$i< count($fields)){
                $str .= "{$glue}";
            }
        }

        return $str;
    }
}