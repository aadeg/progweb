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
        if (!$this->requireField($data, 'action', $err))
            return $err;

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
        if (!$this->requireField($data, 'category', $err))
            return $err;

        $categoryId = $data['category'];
        $custFields = CustomField::getByCategory($categoryId);
        return $custFields;
    }

    private function add($data){
        if (!$this->requireFields($data, ['label', 'type', 'ticket_category'], $err))
            return $err;

        $allowedFields = ['label', 'type', 'ticket_category', 'placeholder',
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
        
        CustomField::create($data);
        return [];
    }

    private function update($data){
        if (!$this->requireFields($data, ['id', 'label', 'type'], $err))
            return $err;

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
        if (!$this->requireField($data, 'id', $err))
            return $err;

        $custFieldId = $data['id'];
        CustomField::delete($custFieldId);
        return [];
    }
}

?>
