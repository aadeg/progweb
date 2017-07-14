<?php
namespace View;

use \Input;
use \AuthManager;
use \Redirect;
use \Session;
use \Config;
use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\PasswordField;


class AdminView {

    public static function login(){
        $view = new \stdClass();

        $form = new Form(array(
            new TextField('username', 'Username',
                          array("placeholder" => "Username",
                                "required" => "", "autofocus" => "")),
            new PasswordField('password', 'Password',
                              array("placeholder" => "Password",
                                    "required" => ""))
        ));
        $view->form = $form;
        
        if (Input::isSubmit()){
            $form->setValues(Input::getAll());
            
            // Login
            $operator = AuthManager::checkLogin(Input::get('username'),
                                                Input::get('password'));
            if ($operator == null){
                Session::flash('Username o password errati', 'error');
                return $view;
            }

            $logged = AuthManager::login($operator->id);
            if (!$logged){
                Session::flash('Account non abilitato', 'error');
                return $view;
            }
             
             $next  = Input::get('next', 'GET');
             if ($next == null || $next[0] !== '/')
                 $next = Config::get('authmanager.index_page');
             Redirect::to($next);
        }
        return $view;
    }
}