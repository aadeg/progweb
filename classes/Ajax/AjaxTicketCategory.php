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
        if (!isset($data['action']))
            return $this->error(400, "Campo 'action' mancante");

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
        if (!isset($data['id']))
            return $this->error(400, "Campo 'id' mancante");
        TicketCategory::delete($data['id']);
        return [];
    }
}

?>
