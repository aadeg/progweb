<?php 
namespace Model;

class Ticket extends BaseModel {
    const TABLE_NAME = 'tickets';

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

    public static function create($cus_first_name, $cus_last_name, 
				  $cus_email, $subject, $category, 
				  $open_at=null){
	if(!$open_at)
	    $open_at = date("Y-m-d H:i:s");

        $ris = self::$db->insert(self::TABLE_NAME, array(
	    "cust_first_name" => $cus_first_name,
	    "cust_last_name" => $cus_last_name, 
	    "cust_email" => $cus_email,
	    "subject" => $subject,
	    "category" => $category, 
	    "open_at" => $open_at
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
