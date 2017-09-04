<?php
namespace Ajax; 

use \Model\TicketCategory;

class AjaxTicketCategory extends AjaxRequest {

    private $userMode;
    
    public function __construct($userMode){
        $this->userMode = $userMode;
    }
    
    protected function getAllowedMethods() { return ['GET', 'POST']; }

    protected function authRequired() { return !$this->userMode; }

    protected function onRequest($data){
        if (!$this->requireField($data, 'action', $err))
            return $err;

        $action = $data['action'];
        unset($data['action']);
        
        if ($action == 'get')
            return $this->get($data);
        if (!$this->userMode && $action == 'delete')
            return $this->delete($data);

        return $this->error(400, "Azione '$action' non valida");
    }

    private function get($data){
        return TicketCategory::getAll()->rows();
    }

    private function delete($data){
        if (!$this->requireField($data, 'id', $err))
            return $err;

        TicketCategory::delete($data['id']);
        return [];
    }
}

?>
