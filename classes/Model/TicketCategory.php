<?php 
namespace Model;

class TicketCategory extends BaseModel {
    const TABLE_NAME = 'ticket_categories';

    public static function getAll(){
        return self::$db->get(self::TABLE_NAME);
    }

    public static function get($fields, $orderBy=array()){
        return self::$db->get(self::TABLE_NAME, $fields,
                              $orderBy);
    }

    public static function getByID($id){
        return self::$db->get(self::TABLE_NAME,
                              array('id' => $id))->first();
    }

    public static function create($label){
        $ris = self::$db->insert(self::TABLE_NAME, array(
            "label" => $label
        ));
        if ($ris->error())
            die($ris->errorMsg());
        return $ris->lastId();
    }

    public static function update($id, $fields){
        return self::$db->update(
            self::TABLE_NAME, $fields, array('id' => $id));
    }

    public static function delete($id){
        $ris = self::$db->delete(self::TABLE_NAME,
                                 array('id' => $id));
        return $ris;
    }

    public static function getNames(){
        $rv = array();
        $cats = self::getAll()->rows();
        foreach ($cats as $cat){
            $rv[$cat->id] = $cat->label;
        }

        return $rv;
    }
}
?>
