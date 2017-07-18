<?php
namespace Ajax; 

use \Model\CustomField;

class AjaxCustomField extends AjaxRequest {
    
    protected function getAllowedMethods() {
	return ['GET'];
    }

    protected function authRequired() { return false; }

    protected function onRequest($data){
	if (!isset($data['category']))
	    return $this->error(400, "Campo 'action' mancante");

	$categoryId = $data['category'];
	$custFields = CustomField::getByCategory($categoryId);
	return $custFields;
    }
}

?>
