<?php
namespace Model;

use \Session;
use \Config;
use \Exception;

class Operator extends BaseModel {
    
    const TABLE_NAME = 'operators';

    
    public static function getAll(){
        return self::$db->get(self::TABLE_NAME);
    }

    public static function get($fields){
        return self::$db->get(self::TABLE_NAME, $fields);
    }

    public static function getByID($operator_id){
        return self::$db->get(self::TABLE_NAME,
                              array('id' => $operator_id))->first();
    }

    public static function create($username, $password, $firstName,
                                  $lastName, $email, $isAdmin){
        $ris = self::$db->insert(self::TABLE_NAME, array(
                    "username" =>   $username,
                    "password" =>   $password,
                    "first_name" => $firstName,
                    "last_name" =>  $lastName,
                    "email" =>      $email,
                    "is_admin" =>   $isAdmin,
                    "enabled" =>    true
                ));
        if ($ris->error())
            die($ris->errorMsg());
    }

}