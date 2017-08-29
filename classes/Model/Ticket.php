<?php 
namespace Model;

use \DateTime;
use \Database\DB;

class Ticket extends BaseModel {
    const TABLE_NAME = 'tickets';

    public static function getAll(){
        return self::$db->get(self::TABLE_NAME);
    }

    public static function get($fields, $orderBy=array()){
        return self::$db->get(self::TABLE_NAME, $fields, $orderBy);
    }

    public static function getById($id){
        return self::$db->get(self::TABLE_NAME,
                              array('id' => $id))->first();
    }

    public static function getByEmail($email){
        return self::$db->get(
            self::TABLE_NAME,
            array('cust_email' => $email),
            array('id' => DB::ORDER_DESC)
        )->rows();
    }

    public static function create($cus_first_name, $cus_last_name, 
                                  $cus_email, $subject, $category, 
                                  $priority=1, $open_at=null){
        if(!$open_at)
            $open_at = date("Y-m-d H:i:s");

        $ris = self::$db->insert(self::TABLE_NAME, array(
            "cust_first_name" => $cus_first_name,
            "cust_last_name" => $cus_last_name, 
            "cust_email" => $cus_email,
            "subject" => $subject,
            "category" => $category, 
            "open_at" => $open_at,
            "last_activity" => $open_at,
            "priority" => $priority
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

    public static function update($id, $fields){
        return self::$db->update(
            self::TABLE_NAME, $fields, array('id' => $id));
    }

    public static function fillCategoryName(&$tickets){
        $categories = TicketCategory::getNames();
        foreach ($tickets as &$ticket)
            $ticket->category = $categories[$ticket->category];
    }

    public static function fillFormattedLastActivity(&$tickets){
        foreach ($tickets as &$ticket){
            $dt = DateTime::createFromFormat(
                'Y-m-d H:i:s', $ticket->last_activity);
            $ticket->last_activity = $dt->format('d/m/Y H:i:s');
        }
    }
}
?>
