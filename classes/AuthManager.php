<?php

use \Model\User;

class AuthManager {

    private static $currentUser = null;

    public static function register($username, $raw_password, $name, $group){
        $password = password_hash($raw_password, PASSWORD_BCRYPT);
        $joined = date('Y-m-d H:i:s');
        User::create($username, $password, $name, $group, $joined);
    }

    public static function checkLogin($username, $raw_password){
        if (!$username || !$raw_password)
            return null;

        $user = User::get(array('username' => $username))->first();

        if (!$user || !password_verify($raw_password, $user->password))
            return null;

        return $user;
    }

    public static function login($user_id){
        // TODO: Verificare che l'utente sia attivo
        Session::put(Config::get('session.session_name'), $user_id);
    }

    public static function logout(){
        self::$currentUser == null;
        Session::delete(Config::get('session.session_name'));
    }

    /** 
     * Restituisce i dettagli dell'utente autenticato tramite il login.
     */
    public static function currentUser(){
        if (self::$currentUser === null){
            $session_name = Config::get('session.session_name');
            if (!Session::exists($session_name))
                return null;
            
            $user_id = Session::get($session_name);
            self::$currentUser = User::getByID($user_id);
        }

        return self::$currentUser;
    }

    public static function isAuthenticated(){
        return self::currentUser() != null;
    }

    public static function loginRequired($next=true){
        $nextPage = $_SERVER['REQUEST_URI'];
        if (!self::isAuthenticated())
            Redirect::to(Config::get('authmanager.login_page'),
                         array("next" => $nextPage));
    }

}