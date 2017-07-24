<?php
namespace View;

use \Input;
use \AuthManager;
use \Redirect;
use \Session;
use \Config;
use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\EmailField;
use \Form\Field\PasswordField;
use \Model\Operator;


class RecoveryView {

    public static function passwordRecovery() {
	$view = new \stdClass();

	$form = new Form(array(
	    new EmailField('email', 'Email',
			   array("placeholder" => "La tua email",
				 "required" => "", "autofocus" => ""))
	));


	$view->form = $form;
	if (Input::isSubmit()){
	    $form->setValues(Input::getAll());

	    // Recovery
	    $email = Input::get('email');
	    if (!$email)
		Redirect::error(400);
	    
	    $operator = Operator::get(array("email" => $email))->first();

	    if ($operator == null){
		Session::flash('L\'email inserita non appartiene ad alcun account',
			       'error');
		return $view;
	    }

	    if (!AuthManager::recover($operator->id)){
		Session::flash("Errore inaspettato durante il recupero " .
			       "della password", "error");
		return $view;
	    }

	    Session::flash("Le è stata inviata un'email all'indirizo $email " .
			   "contenente il codice necessario per recuperare " .
			   "la password.", "success");

	    Session::put("recovery_operator_id", $operator->id);
	    Redirect::to("/admin/recovery_code.php");
	}
	
	return $view;
	
    }

    public static function recoveryCode() {
	$view = new \stdClass();

	$operatorId = Session::get("recovery_operator_id");
	if (!$operatorId){
	    Redirect::to("/admin/password_recovery.php");
	}

	$form = new Form(array(
	    new TextField('code', 'Codice di recupero',
			  array("placeholder" => "Codice ricevuto per email",
				"required" => "", "autofocus" => ""))
	));


	$view->form = $form;
	if (Input::isSubmit()){
	    $form->setValues(Input::getAll());

	    $code = Input::get('code');
	    if (!$code)
		Redirect::error(400);
	    
	    if (!Operator::checkRecoveryToken($operatorId, $code)){
		Session::flash("Codice di recupero errato", "error");
		return $view;
	    }

	    Session::put("recovery_code", $code);
	    Redirect::to("/admin/recovery_change.php");
	}
	
	return $view;
	
    }

    public static function recoveryChange(){
	$view = new \stdClass();

	$operatorId = Session::get("recovery_operator_id");
	$recoveryCode = Session::get("recovery_code");
	if (!$operatorId)
	    Redirect::to("/admin/password_recovery.php");
	if (!$recoveryCode)
	    Redirect::to("/admin/recovery_code.php");

	$form = new Form(array(
	    new PasswordField('password', 'Nuova password',
			      array("placeholder" => "Scegli una nuova password",
				    "required" => "", "autofocus" => "",
				    "pattern" => ".{6,}")),
	    new PasswordField('password-confirm', 'Conferma nuova password',
			      array("placeholder" => "Conferma la password scelta",
				    "required" => "", "pattern" => ".{6,}"))
	));


	$view->form = $form;
	if (Input::isSubmit()){
	    $form->setValues(Input::getAll());

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

	    // Controllo nuovamente il codice per evitare conflitti
	    // con multiple richieste di recupero
	    if (!Operator::checkRecoveryToken($operatorId, $recoveryCode)){
		Session::flash("Errore durante la modifica della password",
			       "error");
		Redirect::to("/admin/password_recovery.php");
	    }

	    AuthManager::changePassword($operatorId, $password);
	    Session::delete("recovery_operator_id");
	    Session::delete("recovery_code");

	    Session::flash("La password è stata cambiata. Adesso può accedere " .
			   "utlizzando la password scelta");
	    Redirect::to("/admin/login.php"); 
	}
	
	return $view;
    }

}
