<?php
namespace Ajax; 

use \AuthManager;
use \Model\Message;
use \Model\Ticket;

class AjaxMessage extends AjaxRequest {
    
    protected function getAllowedMethods() {
	return ['GET', 'POST'];
    }

    protected function onRequest($data){
	if (!isset($data['action']))
	    return $this->error(400, "Campo 'action' mancante");


	$action = $data['action'];
	unset($data['action']);
	if ($action == 'get')
	    return $this->get($data);
	else if ($action == 'add')
	    return $this->add($data);

	return $this->error(400, "Azione '$action' non valida");
    }

    private function get($data){
	if (!isset($data['ticket']))
	    return $this->error(400, "Campo 'ticket' mancante");
	
	$ticketId = $data['ticket'];
	$messageId = null;
	if (isset($data['id']))
	    $messageId = $data['id'];

	if ($messageId)
	    return Message::getById($messageId, $ticketId);
	
	return Message::getByTicketId($ticketId);
    }

    private function add($data){
	$requiredFields = ['ticket', 'message'];
	foreach ($requiredFields as $field){
	    if (!isset($data[$field]))
		return $this->error(400, "Campo '$field' mancante");
	}

	$ticketId = $data['ticket'];
	if (!Ticket::getById($ticketId))
	    return $this->error(400, "Ticket $ticketId non trovato");
	
	$text = $data['message'];
	if ($text == "")
	    return $this->error(400, "Campo 'message' vuoto");
	
	$operatorId = AuthManager::currentOperator()->id;

	$msgId = Message::create($ticketId, Message::TYPE_OPERATOR,
			       $text, $operatorId);

	return ['message' => $msgId];
    }
}

?>
