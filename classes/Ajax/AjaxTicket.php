<?php
namespace Ajax; 

use \Database\DB;
use \DateTime;
use \Model\Ticket;
use \Model\TicketCategory;
use \Model\Operator;

class AjaxTicket extends AjaxRequest {

    private static $filters = array(
        'new' => array(
            'operator' => null
        ),
        'pending' => array(
            'status' => 'pending',
            'operator' => 'not null'
        ),
        'open' => array(
            'status' => 'open',
            'operator' => 'not null'
        )
    );
            

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
        $searchableFields = ['id', 'filter'];
        foreach ($data as $field => $value){
            if (!in_array($field, $searchableFields))
                return $this->error(400, "Campo '$field' non valido");
        }

        $filter = @$data['filter'] ? : null;
        if ($filter)
            unset($data['filter']);
        if ($filter && isset(self::$filters[$filter]))
            $data = array_merge($data, self::$filters[$filter]);
        
        $tickets = Ticket::get(
            $data,
            array("priority" => DB::ORDER_DESC,
                  "last_activity" => DB::ORDER_DESC,
                  "id" => DB::ORDER_ASC))->rows();

        Ticket::fillCategoryName($tickets);
        Ticket::fillFormattedLastActivity($tickets);
        return $tickets;
    }

    private function delete($data){
        if (!isset($data['id']))
                return $this->error(400, "Campo 'id' mancante");

        
        $ris = Ticket::delete($data['id']);
        return [];
    }

    private function edit($data){
        $editableFields = ['priority', 'operator', 'category', 'status'];
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
        $status = @$data['status'] ? : null;
        if ($operatorId == "null"){
            $operatorId = null;
            $data['operator'] = null;
        }

        if ($priority && ($priority < 0 || $priority > 2))
            return $this->error(400, "Priorità non valida");

        if (array_key_exists('operator', $data) &&
            $operatorId && !Operator::getById($operatorId))
            return $this->error(400, "Operatore non valido");

        if ($categoryId && !TicketCategory::getById($categoryId))
            return $this->error(400, "Categoria non valida");

        $validStatus = ['OPEN', 'PENDING', 'CLOSE'];
        if ($status && !in_array($status, $validStatus))
            return $this->error(400, "Status non valido");

        Ticket::update($ticketId, $data);
        return [];
    }
}

?>
