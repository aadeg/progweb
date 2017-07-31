<?php
namespace View;

use \Input;
use \Session;
use \Redirect;
use \Model\Ticket;
use \Model\TicketCategory;
use \Model\CustomField;
use \Form\Form;
use \Form\Field\BaseInputField;
use \Form\Field\TextField;
use \Form\Field\EmailField;
use \Form\Field\SelectField;


class UserView {
    public static function checkTicket(){
	$view = new \stdClass();

	$form = new Form(array(
	    new EmailField('email', 'Indirizzo email*',
			   array("placeholder" => "Email con la quale ha aperto la pratica",
				 "required" => "", "autofocus" => "")),
	    new BaseInputField('number', 'ticket', 'Numero della pratica*',
			  array('placeholder' => 'Numero della pratica',
				'required' => ''))
	));

	$view->form = $form;
	if (Input::isSubmit()){
	    $view->form->setValues(Input::getAll());

	    $requiredFields = ['email', 'ticket'];
	    foreach ($requiredFields as $field){
		if (!Input::get($field)){
		    Session::flash('Compila tutti i campi', 'error');
		    return $view;
		}
	    }

	    $email = Input::get('email');
	    $ticketId = Input::get('ticket'); 

	    $ticket = Ticket::getById($ticketId);
	    if (!$ticket || $ticket->cust_email != $email){
		Session::flash("I dati inseriti non sono corretti", "error");
		return $view;
	    }

	    // Valid input
	    Session::put('cust_ticket_id', $ticketId);
	    Redirect::to('ticket_view.php?id=' . $ticketId);
	}
	
	return $view;
    }

    public static function ticketView(){
	$view = new \stdClass();

	$inputTicketId = Input::get('id');
	
	if (!$inputTicketId || !Session::exists('cust_ticket_id'))
	    Redirect::to('/check_ticket.php');

	$ticketId = Session::get('cust_ticket_id');
	if ($ticketId != $inputTicketId){
	    Session::flash('Errore durante la Visualizzazione della pratica. ' .
			   'Si prega di riprovare', 'error');
	    Redirect::to('/check_ticket.php');
	}

	$ticket = Ticket::getById($ticketId);
	if (!$ticket){
	    Session::flash('Pratica non trovata', 'error');
	    Session::delete('cust_ticket_id');
	    Redirect::to('/check_ticket.php');
	}

	$view->ticket = $ticket;
	return $view;
    }
}
?>
