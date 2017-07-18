<?php 
namespace Model;

use \Database\DB;

class CustomField extends BaseModel {
    const TABLE_NAME = 'custom_fields';

    public static function getAll(){
	return self::$db->get(self::TABLE_NAME);
    }

    public static function get($fields){
	return self::$db->get(self::TABLE_NAME, $fields);
    }

    public static function getByID($id){
        return self::$db->get(self::TABLE_NAME,
                              array('id' => $id))->first();
    }

    public static function getByCategory($categoryId){
	return self::$db->get(
	    self::TABLE_NAME,
	    array('ticket_category' => $categoryId),
	    array('order_index' => DB::ORDER_ASC,
		  'id' => DB::ORDER_ASC)
	)->rows();
    }

    public static function create(){
	/*
        $ris = self::$db->insert(self::TABLE_NAME, array(
	    "cus_first_name" => $cus_first_name,
	    "cus_last_name" => $cus_last_name, 
	    "cus_email" => $cus_email,
	    "subject" => $subject,
	    "category" => $category, 
	    "open_at" => $open_at
	));
        if ($ris->error())
            die($ris->errorMsg());*/
    }

    public static function delete($id){
	$ris = self::$db->delete(self::TABLE_NAME,
				 array('id' => $id));
	return $ris;
    }
}
?>
