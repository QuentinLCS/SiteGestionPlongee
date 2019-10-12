<?php

require_once('_Model.php');

class SiteManager extends _Model
{
    public static $entity = 'SITE';
    public static $table = 'PLO_SITE';

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
        DataBase::$db->majDonnees("UPDATE ".self::$table." SET SIT_NOM = '".$object[0]->getSitNom()."', SIT_LOCALISATION = '".$object[0]->getSitLocalisation()."' WHERE SIT_NUM = '".$object[0]->getSitNum()."'");
    }
}