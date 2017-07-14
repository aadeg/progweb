<?php
namespace Ajax; 

use \Model\Ticket;

class AjaxTicket extends AjaxRequest {
    
    protected function getAllowedMethods() {
	 return ['GET', 'POST'];
    }

    protected function onRequest($data){
	if (!isset($data['action'])){
	    die(var_dump($data));
	    return $this->error(400, "Campo 'action' mancante");
	}

	$action = $data['action'];
	unset($data['action']);
	if ($action == 'get'){
	    return $this->get($data);
	} else if ($action == 'delete') {
	    return $this->delete($data);
	}

	return $this->error(400, "Azione '" . $action . "' non valida");
    }

    private function get($data){
	$searchableField = ['id', 'cust_first_name', 'cust_last_name',
			    'cust_email', 'subject', 'category',
			    'operator', 'status'];

	foreach ($data as $field => $value){
	    if (!in_array($field, $searchableField))
		return $this->error(400, "Campo '" . $field . "' non valido");
	}
	if (isset($data['operator']) && $data['operator'] == 'null')
	    $data['operator'] = null;
	
	$tickets = Ticket::get($data)->rows();
	return $tickets;
    }

    protected function delete($data){
	if (!isset($data['id']))
		return $this->error(400, "Campo 'id' mancante");

	
	$ris = Ticket::delete($data['id']);
	return [];
    }
}

?>
