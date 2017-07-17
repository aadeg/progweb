<?php
namespace View;

use \Model\Ticket;
use \Model\TicketCategory;
use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\EmailField;
use \Form\Field\SelectField;


class UserView {
    public static function newTicket(){
	$view = new \stdClass();

	$ticketCat = TicketCategory::getAll()->rows();
	$categories = array("" => "");
	foreach ($ticketCat as $t){
	    $categories[$t->id] = $t->label;
	}
	


	$form = new Form(array(
	    new TextField('first_name', 'Nome',
			  array("placeholder" => 'Il suo nome',
				"required" => "",
				"autofocus" => "")),
	    new TextField('last_name', 'Cognome',
			 array("placeholder" => 'Il suo cognome',
			       "required" => "")),
	    new EmailField('email', 'Email',
			   array("placeholder" => "Email sulla quale verrà contattato",
				 "required" => "")),
	    new SelectField('category', "Tipologia di problema",
			    $categories,
			    array("required" => ""))
	));
	$view->form = $form;
	return $view;
    }
}
?>
