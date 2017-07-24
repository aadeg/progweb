<?php
namespace Ajax; 

use \Model\Ticket;
use \Model\TicketCategory;
use \Model\Operator;

class AjaxTicket extends AjaxRequest {
    
    protected function getAllowedMethods() {
	 return ['GET', 'POST'];
    }

    protected function onRequest($data){
	if (!isset($data['action']))
	    return $this->error(400, "Campo 'action' mancante");


	$action = $data['action'];
	unset($data['action']);
	if ($action == 'get'){
	    return $this->get($data);
	} else if ($action == 'delete') {
	    return $this->delete($data);
	} else if ($action == 'edit') {
	    return $this->edit($data);
	}

	return $this->error(400, "Azione '$action' non valida");
    }

    private function get($data){
	$searchableFields = ['id', 'cust_first_name', 'cust_last_name',
			    'cust_email', 'subject', 'category',
			    'operator', 'status'];

	foreach ($data as $field => $value){
	    if (!in_array($field, $searchableFields))
		return $this->error(400, "Campo '$field' non valido");
	}
	if (isset($data['operator']) && $data['operator'] == 'null')
	    $data['operator'] = null;
	
	$tickets = Ticket::get($data)->rows();
	return $tickets;
    }

    private function delete($data){
	if (!isset($data['id']))
		return $this->error(400, "Campo 'id' mancante");

	
	$ris = Ticket::delete($data['id']);
	return [];
    }

    private function edit($data){
	$editableFields = ['priority', 'operator', 'category'];
	if (!isset($data['id']))
	    return $this->error(400, "Campo 'id' mancante");

	$ticketId = $data['id'];
	unset($data['id']);
	foreach ($data as $key => $value){
	    if (!in_array($key, $editableFields))
		return $this->error(400, "Campo '{$key}' non modificabile");
	}

	// operator can be null
	$priority = @$data['id'] ? : null;
	$operatorId = @$data['operator'] ? : null;
	$categoryId = @$data['category'] ? : null;
	if ($operatorId == "null")
	    $operatorId = null;

	if ($priority && ($priority < 0 || $priority > 2))
	    return $this->error(400, "Priorità non valida");

	if (array_key_exists('operator', $data) &&
	    $operatorId && !Operator::getById($operatorId))
	    return $this->error(400, "Operatore non valido");

	if ($categoryId && !TicketCategory::getById($categoryId))
	    return $this->error(400, "Categoria non valida");


	Ticket::update($ticketId, $data);
	return [];
    }
}

?>
