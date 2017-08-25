<?php
namespace Ajax; 

use \Model\TicketCategory;

class AjaxTicketCategory extends AjaxRequest {
    
    protected function getAllowedMethods() {
        return ['GET'];
    }

    protected function authRequired() { return false; }

    protected function onRequest($data){
        return TicketCategory::getAll()->rows();
    }
}

?>
