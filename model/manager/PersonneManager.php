<?php

require_once('_Model.php');

class PersonneManager extends _Model
{
    public static $entity = 'Personne';
    public static $table = 'PLO_PERSONNE';

    public function getAll()
    {
        return parent::_getAll(self::$table, self::$entity);
    }

    public function getAllInactives() {
        return DataBase::$db->LireDonnees('SELECT * FROM '.self::$table." WHERE PER_ACTIVE = '0'", self::$entity);
    }

    public function getSearchResult($search)
    {
        return DataBase::$db->LireDonnees('SELECT * FROM '.self::$table." WHERE PER_NOM LIKE '".$search."%'", self::$entity);
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
            DataBase::$db->majDonnees("INSERT INTO ".self::$table." (PER_NOM, PER_PRENOM) VALUES ('".$object[0]->getPerNom()."', '".$object[0]->getPerPrenom()."')");
        else
            DataBase::$db->majDonnees("UPDATE ".self::$table." SET PER_NOM = '".$object[0]->getPerNom()."', PER_PRENOM = '".$object[0]->getPerPrenom()."' WHERE PER_NUM = '".$object[0]->getPerNum()."'");
    }
}