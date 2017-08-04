<?php
namespace Ajax; 

use \Model\CustomField;

class AjaxCustomField extends AjaxRequest {

    private $userMode;
    
    public function __construct($userMode){
	$this->userMode = $userMode;
    }

    protected function authRequired() { return !$this->userMode; }
    
    protected function getAllowedMethods() { return ['GET', 'POST']; }

    protected function onRequest($data){
	if (!isset($data['action']))
	    return $this->error(400, "Campo 'action' mancante");

	$action = $data['action'];
	unset($data['action']);
	
	if ($action == 'get')
	    return $this->get($data);
	if (!$this->userMode){
	    if ($action == 'add')
		return $this->add($data);
	    else if ($action == 'update')
	        return $this->update($data);
	    else if ($action == 'delete')
	        return $this->delete($data);
	}
	

	return $this->error(400, "Azione '$action' non valida");
    }

    private function get($data){
	if (!isset($data['category']))
	    return $this->error(400, "Campo 'category' mancante");

	$categoryId = $data['category'];
	$custFields = CustomField::getByCategory($categoryId);
	return $custFields;
    }

    private function add($data){
	return [];
    }

    private function update($data){
	$requiredFields = ['id', 'label', 'type'];
	foreach ($requiredFields as $req){
	    if (!isset($data[$req]))
		return $this->error(400, "Campo '{$req}' mancante");
	}
	$allowedFields = ['id', 'label', 'type', 'placeholder',
			  'order_index', 'required', 'default_value',
			  'min_value', 'max_value', 'regex_pattern',
			  'select_options'];
	foreach ($data as $key => &$value){
	    if (!in_array($key, $allowedFields))
		return $this->error(400, "Campo '{$key}' non valido");

	    $value = ($value == '') ? null : $value;
	}
	if (isset($data['required']) && $data['required'] == 'true')
	    $data['required'] = true;
	else
	    $data['required'] = false;
	
	$custFieldId = $data['id'];
	unset($data['id']);

	CustomField::update($custFieldId, $data);
	return [];
    }

    private function delete($data){
	if (!isset($data['id']))
	    return $this->error(400, "Campo 'id' mancante");

	$custFieldId = $data['id'];
	CustomField::delete($custFieldId);
	return [];
    }
}

?>
