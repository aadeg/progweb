<?php
namespace Model;

use \Session;

class User {
    
    const TABLE_NAME = 'users';

    public static function getAll($db){
        return $db->get(self::TABLE_NAME);
    }

    public static function create($db, $username, $password, $name,
                                  $group, $joined){
        $ris = $db->insert(self::TABLE_NAME, array(
                    "username" =>   $username,
                    "password" =>   $password,
                    "name" =>       $name,
                    "group" =>      $group,
                    "joined" =>     $joined
                ));
        if ($ris->error()){
            throw new Exception("Errore durante la creazione di User");
        }
    }
    /* 
     * ========================================================================
     *                              Authentication             
     * ========================================================================
     */

    public static function register($db, $username, $raw_password, $name,
                                    $group){
        $password = password_hash($raw_password, PASSWORD_BCRYPT);
        $joined = date('Y-m-d H:i:s');
        self::create($db, $username, $password, $name, $group, $joined);
    }

    public static function checkLogin($db, $username, $raw_password){
        if (!$username || !$raw_password)
            return null;

        $user = $db->get(self::TABLE_NAME,
                         array('username' => $username))->first();
        if (!$user)     // No user found
            return null;

        if (!password_verify($raw_password, $user->password))
            return null;
        return $user;
    }

    public static function login($db, $user_id){
        // Check if the user is active
        Session::put(Config::get('session.session_name'), $user_id);
    }
    
}