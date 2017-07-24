<?php 
namespace Model;

use \Database\DB;

class Message extends BaseModel {
    const TABLE_NAME = 'messages';

    const TYPE_CUSTOMER = 'CUSTOMER';
    const TYPE_OPERATOR = 'OPERATOR';
    const TYPE_INTERNAL = 'INTERNAL';

    public static function getAll(){
	return self::$db->get(self::TABLE_NAME);
    }

    public static function get($fields){
	return self::$db->get(self::TABLE_NAME, $fields);
    }

    public static function getById($id, $ticketId){
        return self::$db->get(
	    self::TABLE_NAME,
	    array('id' => $id, 'ticket' => $ticketId)
	)->first();
    }

    public static function getByTicketId($ticketId){
	return self::$db->get(
	    self::TABLE_NAME, array('ticket' => $ticketId),
	    array('send_at' => DB::ORDER_ASC)
	)->rows();
    }

    public static function create($ticketId, $type, $text,
				  $operatorId=null, $sentAt=null){
	if(!$sentAt)
	    $sentAt = date("Y-m-d H:i:s");

        $ris = self::$db->insert(self::TABLE_NAME, array(
	    "ticket" => $ticketId,
	    "type" => $type, 
	    "operator" => $operatorId,
	    "text" => $text,
	    "send_at" => $sentAt
	));
        if ($ris->error())
            die($ris->errorMsg());
	return $ris->lastId();
    }

    public static function delete($id){
	$ris = self::$db->delete(self::TABLE_NAME,
				 array('id' => $id));
	return $ris;
    }
}
?>
