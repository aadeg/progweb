<?php
namespace View;

use \DateTime;
use \Input;
use \AuthManager;
use \Redirect;
use \Session;
use \Config;
use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\EmailField;
use \Form\Field\HiddenField;
use \Form\Field\PasswordField;
use \Model\Ticket;
use \Model\TicketCategory;
use \Model\Message;
use \Model\Operator;


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

    public static function ticketView(){
	$view = new \stdClass();

	$ticketId = Input::get('id');
	if (!$ticketId)
	    Redirect::error(404);
	
	$ticket = Ticket::getById($ticketId);
	if (!$ticket)
	    Redirect::error(404);

	// Customer Full Name
	$view->customerFullName = $ticket->cust_last_name . ' ' . $ticket->cust_first_name;

	// Open At
	$openAtDate = DateTime::createFromFormat(
	    'Y-m-d H:i:s', $ticket->open_at);
	$view->openAtStr = $openAtDate->format('d M Y - H:i');

	// Categories
	$view->categories = TicketCategory::getAll()->rows();


	// Priority
	$priorClasses = ['priority-low', 'priority-normal', 'priority-high'];
	$view->priorityClass = $priorClasses[$ticket->priority];

	// Operators
	$view->operators = Operator::getAll()->rows();
	
	$view->ticket = $ticket;

	return $view;
    }

    public static function profile(){
	$view = new \stdClass();
	
	$operatorId = Input::get('id', 'GET');
	
	$currentOperator = AuthManager::currentOperator();
	if (!$operatorId)
	    $operatorId = $currentOperator->id;

	$operator = Operator::getById($operatorId);
	if (!$operator)
	    Redirect::error(404);

	$view->operator = $operator;
	$view->currentOperator = $currentOperator;

	$baseActionForm = "?id=" . $operatorId;
	
	// Password change
	$passwordForm = new Form(array(
	    new PasswordField('password', 'Nuova password',
			      array("placeholder" => "Scegli una nuova password",
				    "required" => "", "pattern" => ".{6,}")),
	    new PasswordField('password-confirm', 'Conferma password',
			      array("placeholder" => "Conferma la nuova password",
				    "required" => "", "pattern" => ".{6,}")),
	));
	$view->passwordForm = $passwordForm;
	$view->passwordFormAction = $baseActionForm . "&action=change-password";

	// Enable / Disable
	if ($operator->enabled)
	    $view->toggleBtn = "Disattiva account";
	else
	    $view->toggleBtn = "Attiva account";
	$view->toggleFormAction = $baseActionForm . "&action=toggle-account";

	// Info
	if ($currentOperator->id == $operatorId){
	    $view->title = "Il tuo profilo";
	    $view->ownProfile = true;
	} else {
	    $view->title = "Profilo di {$operator->username}";
	    $view->ownProfile = false;
	}

	$view->isAdmin = $currentOperator->is_admin;

	// Submit
	if (Input::isSubmit('POST', true)){
	    $action = Input::get('action', 'GET');
	    if (!$action)
		Redirect::error(400);
	    if ($action == 'change-password'){
		return self::profileChangePassword($view);
	    } else if ($action == 'toggle-account') {
		return self::profileToggleAccount($view);
	    }
	    
	}

	return $view;
    }

    private static function profileChangePassword($view){
	$operatorId = $view->operator->id;
	$currentOperator = $view->currentOperator;

	if ($operatorId != $currentOperator->id && !$currentOperator->is_admin)
	    Redirect::error(403);

	$password = Input::get('password');
	$passwordConfirm = Input::get('password-confirm');

	if (!$password || !$passwordConfirm)
		Redirect::error(400);

	if ($password != $passwordConfirm){
	    Session::flash("Le password inserite non sono uguali", "error");
	    return $view;
	}
	
	if (strlen($password) < 6){
	    Session::flash("La password deve essere di almeno 6 caratteri");
	    return $view;
	}

	AuthManager::changePassword($operatorId, $password);
	Operator::resetRecoveryToken($operatorId);
	
	Session::flash("Password cambiata correttamente");
	Redirect::to("?id=" . $operatorId);
    }

    private static function profileToggleAccount($view){
	$operatorId = $view->operator->id;
	$currentOperator = $view->currentOperator;

	$enabled = !$view->operator->enabled;
	Operator::update($operatorId, array("enabled" => $enabled));
	if ($enabled)
	    Session::flash("Account attivato");
	else
	    Session::flash("Account disattivato");
	Redirect::to("?id=" . $operatorId);
    }
}
