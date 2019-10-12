<?php

require_once('_Model.php');

class AptitudeManager extends _Model
{
    public static $entity = 'Aptitude';
    public static $table = 'PLO_APTITUDE';

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
        if ($add)
            DataBase::$db->majDonnees("INSERT INTO ".self::$table." (APT_CODE, APT_LIBELLE) VALUES ('".$object[0]->getAptCode()."', '".$object[0]->getAptLibelle()."')");
        else
            DataBase::$db->majDonnees("UPDATE ".self::$table." SET APT_CODE = '".$object[0]->getAptCode()."', APT_LIBELLE = '".$object[0]->getAptLibelle()."' WHERE APT_CODE = '".$object[0]->getOldAptCode()."'");
    }
}