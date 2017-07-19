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
use \Form\Field\PasswordField;
use \Model\Ticket;
use \Model\Message;


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

	// Messages
	$messages = Message::getByTicketId($ticketId);

	$view->ticket = $ticket;
	$view->messages = $messages;
	return $view;
    }
}
