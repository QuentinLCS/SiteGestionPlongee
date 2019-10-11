<?php

require_once('_Model.php');

class PlongeurManager extends _Model
{
    public static $entity = 'PLONGEUR';
    public static $table = 'PLO_PLONGEUR';

    public function __construct()
    {
        // Actions à la création de l'entité.
    }

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

    public function update($object)
    {
        DataBase::$db->majDonnees("UPDATE ".self::$table." SET APT_CODE = '".$object[0]->getAptCode()."' WHERE PER_NUM = '".$object[0]->getPerNum()."'");
        (new PersonneManager())->update($object[0]->getPersonne());
    }
}