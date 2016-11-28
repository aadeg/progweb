<?php
namespace Model;

use \Session;
use \Config;

class User {
    
    const TABLE_NAME = 'users';

    private static $db;

    /* 
     * ========================================================================
     *                                 Init             
     * ========================================================================
     */
    public static function setDatabase($db){
        self::$db = $db;
    }

    /* 
     * ========================================================================
     *                                Database             
     * ========================================================================
     */
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
        if ($ris->error()){
            throw new Exception("Errore durante la creazione di User");
        }
    }

    /* 
     * ========================================================================
     *                              Authentication             
     * ========================================================================
     */
    public static function register($username, $raw_password, $name,
                                    $group){
        $password = password_hash($raw_password, PASSWORD_BCRYPT);
        $joined = date('Y-m-d H:i:s');
        self::create($username, $password, $name, $group, $joined);
    }

    public static function checkLogin($username, $raw_password){
        if (!$username || !$raw_password)
            return null;

        $user = self::$db->get(self::TABLE_NAME,
                               array('username' => $username))->first();
        if (!$user)     // No user found
            return null;

        if (!password_verify($raw_password, $user->password))
            return null;
        return $user;
    }

    public static function login($user_id){
        // TODO: Verificare che l'utente sia attivo
        Session::put(Config::get('session.session_name'), $user_id);
    }

    public static function logout(){
        Session::delete(Config::get('session.session_name'));
    }

    /* 
     * ========================================================================
     *                                  Session             
     * ========================================================================
     */
    /** 
     * Restituisce i dettagli dell'utente autenticato tramite il login.
     */
    public static function currentUser(){
        $session_name = Config::get('session.session_name');
        if (!Session::exists($session_name))
            return null;
        
        $user_id = Session::get($session_name);
        return User::getByID($user_id);
    }
}