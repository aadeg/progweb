<?php
namespace Model;

use \Session;
use \Config;
use \Exception;

class User extends BaseModel {
    
    const TABLE_NAME = 'users';

    
    public static function getAll(){
        return self::$db->get(self::TABLE_NAME);
    }

    public static function get($fields){
        return self::$db->get(self::TABLE_NAME, $fields);
    }

    public static function getByID($user_id){
        return self::$db->get(self::TABLE_NAME,
                              array('id' => $user_id))->first();
    }

    public static function create($username, $password, $name,
                                  $group, $joined){
        $ris = self::$db->insert(self::TABLE_NAME, array(
                    "username" =>   $username,
                    "password" =>   $password,
                    "name" =>       $name,
                    "group" =>      $group,
                    "joined" =>     $joined
                ));
        if ($ris->error())
            die($ris->errorMsg());
    }

}