<?php
namespace Ajax; 

use \Model\Ticket;
use \Model\Message;
use \Model\TicketCategory;
use \Model\CustomField;

class AjaxNewTicket extends AjaxRequest {

    const EMAIL_PATTERN = "/(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/";
    const NUM_PATTERN = "/^\d+$/";
    
    protected function getAllowedMethods() {
	return ['POST'];
    }

    protected function authRequired() { return false; }

    protected function onRequest($data){
	if (!$this->isValid($data))
	    return $this->error(400, "Richiesta non valida");

	$firstName = $data['first-name'];
	$lastName = $data['last-name'];
	$email = $data['email'];
	$categoryId = $data['category'];
	$subject = $data['subject'];
	$message = $this->getCustomFieldsMsg($categoryId, $data);
	$message .= $data['message'];


	$ticketId = Ticket::create($firstName, $lastName, $email,
				   $subject, $categoryId);
	Message::create($ticketId, Message::TYPE_CUSTOMER, $message);

	return ["ticket" => $ticketId];
    }

    private function getCustomFieldsMsg($categoryId, $data){
	$msg = "";
	$customFields = CustomField::getByCategory($categoryId);
	foreach ($customFields as $field){
	    $name = 'custom-' . $field->id;

	    $value = @$data[$name] ? : '';
	    $msg .= "{$field->label}:  $value\n";
	}

	return $msg;
    }

    private function isValid($data){
	$requiredFields = [
	    'first-name', 'last-name', 'email',
	    'category', 'subject', 'message'];
	foreach ($requiredFields as $field){
	    if (!isset($data[$field]))
		return false;
	}

	if (!preg_match(self::EMAIL_PATTERN, $data['email']))
	    return false;

	if (!preg_match(self::NUM_PATTERN, $data['category']) ||
	    !TicketCategory::getById($data['category'])){
	    return false;
	}

	// Custom fields validation
	$customFields = CustomField::getByCategory($data['category']);
	foreach ($customFields as $field){
	    $name = 'custom-' . $field->id;
	    
	    if ($field->required == 1 && !isset($data[$name]))
		return false;
	    if (!isset($data[$name]))
		continue;

	    $value = $data[$name];
	    if ($field->type == 'email' &&
		!preg_match(self::EMAIL_PATTERN, $value)){
		return false;
	    } else if ($field->type == 'number') {
		if (!preg_match(self::NUM_PATTERN, $value))
		    return false;


		$num = intval($value);
		if ($field->min_value && $num < $field->min_value)
		    return false;
		if ($field->max_value && $num > $field->max_value)
		    return false;
	    } else if ($field->type == 'select') {
		$options = explode(',', $field->select_options);
		if (!in_array($value, $options))
		    return false;
	    } else if ($field->type == 'text' &&
		       $field->regex_pattern &&
		       !preg_match($field->regex_pattern, $value)) {
		return false;
	    }
	}
	
	return true;
    }
}

?>
