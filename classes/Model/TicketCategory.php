<?php 
namespace Model;

class TicketCategory extends BaseModel {
    const TABLE_NAME = 'ticket_categories';

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

    public static function create($label, $parent=null){
        $ris = self::$db->insert(self::TABLE_NAME, array(
	    "label" => $label,
	    "parent" => $parent
	));
        if ($ris->error())
            die($ris->errorMsg());
    }

    public static function delete($id){
	$ris = self::$db->delete(self::TABLE_NAME,
				 array('id' => $id));
	return $ris;
    }
}
?>
