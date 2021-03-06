<?php

require_once('_Model.php');

class EmbarcationManager extends _Model
{
    public static $entity = 'Embarcation';
    public static $table = 'PLO_EMBARCATION';

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
    public function getEmbarcationPlongee($valeur)
    {
        $req="select * from ".self::$table." join PLO_PLONGEE using (EMB_NUM) WHERE EMB_NUM=$valeur";
        return DataBase::$db->LireDonnees($req,self::$entity);
    }
}