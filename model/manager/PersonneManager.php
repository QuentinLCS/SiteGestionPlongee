<?php

require_once('_Model.php');

class PersonneManager extends _Model
{
    public static $entity = 'PERSONNE';
    public static $table = 'PLO_PERSONNE';

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
        DataBase::$db->majDonnees("UPDATE ".self::$table." SET PER_NOM = '".$object[0]->getPerNom()."', PER_PRENOM = '".$object[0]->getPerPrenom()."' WHERE PER_NUM = '".$object[0]->getPerNum()."'");
    }
}