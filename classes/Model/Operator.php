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

    public static function update($id, $fields){
        return self::$db->update(
            self::TABLE_NAME, $fields, array('id' => $id));
    }

    public static function resetRecoveryToken($id){
        self::update($id, array("recovery_token" => null));
    }
    
    public static function setRecoveryToken($id){
        $token = rand(10000, 999999);
        self::update($id, array("recovery_token" => $token));
        return $token;
    }

    public static function checkRecoveryToken($id, $token){
        $operator = self::getById($id);
        return $operator && $operator->recovery_token == $token;
    }
}
