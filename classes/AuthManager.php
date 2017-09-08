<?php

use \Model\Operator;
use \Email\EmailSender;

class AuthManager {

    private static $currentOperator = null;

    public static function register($username, $rawPassword, $firstName,
                                    $lastName, $email, $isAdmin){
        $password = password_hash($rawPassword, PASSWORD_BCRYPT);
        Operator::create($username, $password, $firstName, $lastName,
                         $email, $isAdmin);
    }

    public static function changePassword($operatorId, $newPassword){
        $password = password_hash($newPassword, PASSWORD_BCRYPT);
        Operator::update($operatorId, array("password" => $password));
        Operator::resetRecoveryToken();
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
        if ($operator->recovery_token !== null)
            Operator::resetRecoveryToken($operator_id);


        Session::put(Config::get('session.session_name'), $operator_id);
        return true;
    }

    public static function logout(){
        self::$currentOperator == null;
        Session::delete(Config::get('session.session_name'));
    }

    public static function recover($operator_id){
        $token = Operator::setRecoveryToken($operator_id);
        $operator = Operator::getById($operator_id);

        $op_full_name = "{$operator->first_name} {$operator->last_name}";
        $addrs = array(
            array("email" => $operator->email, "name" => $op_full_name)
        );
        $subject = "Recupero della password";
        $body = "Buongiorno $op_full_name,\n";
        $body .= "Come da lei richiesto, le inviamo le informazioni necessarie per recuperare la sua password.\n";
        $body .= "Il codice per recuperare la password è:\n\n";
        $body .= "$token\n\n";
        $body .= "SimpleTicket";

        if (!EmailSender::send($addrs, $subject, $body)){
        die(EmailSender::getErrorMsg());
        return false;
    }
        return true;    

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
            if (!self::$currentOperator->enabled)
                self::$currentOperator = null;
        }

        return self::$currentOperator;
    }

    public static function isAuthenticated(){
        return self::currentOperator() != null;
    }
    
    public static function loginRequired(){
        $nextPage = $_SERVER['REQUEST_URI'];
        if (!self::isAuthenticated())
            Redirect::to(Config::get('authmanager.login_page'),
                         array("next" => $nextPage));
    }

    public static function adminRequired(){
        $operator = self::currentOperator();
        if (!$operator || !$operator->is_admin)
            Redirect::error(403);
    }

}
