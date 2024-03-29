<?php
namespace Ajax; 

use \DateTime;
use \Session;
use \AuthManager;
use \Model\Message;
use \Model\Ticket;
use \Model\Operator;

class AjaxMessage extends AjaxRequest {

    private $userMode;
    
    public function __construct($userMode){
        $this->userMode = $userMode;
    }

    protected function authRequired() { return !$this->userMode; }
    
    protected function getAllowedMethods() {
        return ['GET', 'POST'];
    }

    protected function onRequest($data){
        if (!$this->requireFields($data, ['action', 'ticket'], $err))
            return $err;

        $action = $data['action'];
        $ticketId = $data['ticket'];
        unset($data['action']);
        unset($data['ticket']);
        
        if ($action == 'get')
            return $this->get($ticketId, $data);
        else if ($action == 'add')
            return $this->add($ticketId, $data);

        return $this->error(400, "Azione '$action' non valida");
    }

    private function get($ticketId, $data){
        if (!$this->hasPermission($ticketId))
                return $this->error(403, "Azione non permessa");
        
        $messageId = null;
        if (isset($data['id']))
            $messageId = $data['id'];

        if ($messageId){
            $msg = Message::getById($messageId, $ticketId);
            $this->putOperatorName($msg);
            $this->formatSendAt($msg);
            return $msg;
        }

        $msgs = Message::getByTicketId($ticketId);
        foreach ($msgs as &$msg){
            $this->putOperatorName($msg);
            $this->formatSendAt($msg);
        }

        return $msgs;
    }

    private function putOperatorName(&$msg){
        if (!$msg || $msg->type != Message::TYPE_OPERATOR || !$msg->operator)
            return;

        $operator = Operator::getById($msg->operator);
        if (!$operator)
            return;

        $msg->operator_name = $operator->first_name;
        if (!$this->userMode)
            $msg->operator_name .= ' ' . $operator->last_name;
    }

    private function formatSendAt(&$msg){
        $dt = DateTime::createFromFormat(
            'Y-m-d H:i:s', $msg->send_at);
        $msg->send_at = $dt->format('d/m/Y H:i');
    }

    private function add($ticketId, $data){
        if (!$this->hasPermission($ticketId))
            return $this->error(403, "Azione non permessa");
        if (!$this->requireField($data, 'message', $err))
            return $err;

        $ticket = Ticket::getById($ticketId);
        if (!$ticket)
            return $this->error(400, "Ticket $ticketId non trovato");
        if ($ticket->status == 'CLOSE')
            return $this->error(400, "Ticket chiuso");
        
        $text = $data['message'];
        if ($text == "")
            return $this->error(400, "Campo 'message' vuoto");

        $msgType = $this->userMode ? Message::TYPE_CUSTOMER : Message::TYPE_OPERATOR;
        $operatorId = $this->userMode ? null : AuthManager::currentOperator()->id;

        $msgId = Message::create($ticketId, $msgType, $text, $operatorId);

        return ['message' => $msgId];
    }

    private function hasPermission($ticketId){
        if (!$this->userMode)
            return true;
                
        $allowedTicketId = Session::get('cust_ticket_id');
        if (!$allowedTicketId || $allowedTicketId != $ticketId)
            return false;
        return true;
    }
}

?>
