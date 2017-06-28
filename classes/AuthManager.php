<?php

use \Model\Operator;

class AuthManager {

    private static $currentOperator = null;

    public static function register($username, $rawPassword, $firstName,
                                    $lastName, $email, $isAdmin){
        $password = password_hash($rawPassword, PASSWORD_BCRYPT);
        Operator::create($username, $password, $firstName, $lastName,
                         $email, $isAdmin);
    }

    public static function checkLogin($username, $rawPassword){
        if (!$username || !$rawPassword)
            return null;

        $operator = Operator::get(array('username' => $username))->first();

        if (!$operator || !password_verify($rawPassword, $operator->password))
            return null;

        return $operator;
    }

    public static function login($operator_id){
        $operator = Operator::getByID($operator_id);
        if (!$operator->enabled)
            return false;

        Session::put(Config::get('session.session_name'), $operator_id);
        return true;
    }

    public static function logout(){
        self::$currentOperator == null;
        Session::delete(Config::get('session.session_name'));
    }

    /** 
     * Restituisce i dettagli dell'operatore autenticato tramite il login.
     */
    public static function currentOperator(){
        if (self::$currentOperator === null){
            $session_name = Config::get('session.session_name');
            if (!Session::exists($session_name)){
                return null;
            }
            
            $operator_id = Session::get($session_name);
            self::$currentOperator = Operator::getByID($operator_id);
        }

        return self::$currentOperator;
    }

    public static function isAuthenticated(){
        return self::currentOperator() != null;
    }

    public static function loginRequired($next=true){
        $nextPage = $_SERVER['REQUEST_URI'];
        if (!self::isAuthenticated())
            Redirect::to(Config::get('authmanager.login_page'),
                         array("next" => $nextPage));
    }

}