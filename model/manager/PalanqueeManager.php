<?php

require_once('_Model.php');

class PalanqueeManager extends _Model
{
    public static $entity = 'Palanquee';
    public static $table = 'PLO_PALANQUEE';

    public function getAll()
    {
        return parent::_getAll(self::$table, self::$entity);
    }

    public function countAll()
    {
        return parent::_countAll(self::$table);
    }

    public function getOne(array $id)
    {
        return parent::_getOne(self::$table, $id, self::$entity);
    }

    public function update($object, $add = false)
    {
        // TODO: Implement update() method.
    }
    public function getPlongeePalanquee($donne1,$donne2)
    {
        $req="select * from ".self::$table." join PLO_PLONGEE using (PLO_DATE,PLO_MAT_MID_SOI) WHERE PLO_DATE='$donne1' and PLO_MAT_MID_SOI='$donne2'";
        return DataBase::$db->LireDonnees($req,self::$entity);
    }
}