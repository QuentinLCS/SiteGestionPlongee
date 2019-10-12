<?php

require_once('_Model.php');

class PlongeurManager extends _Model
{
    public static $entity = 'PLONGEUR';
    public static $table = 'PLO_PLONGEUR';

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
        $personneManager = new PersonneManager();
        $personneManager->update($object[0]->getPersonne(), $add);

        if ($add) {
            $personne = $personneManager->getOne([
                'PER_NOM' => $object[0]->getPersonne()[0]->getPerNom(),
                'PER_PRENOM' => $object[0]->getPersonne()[0]->getPerPrenom(),
                ]);

            DataBase::$db->majDonnees("INSERT INTO " . self::$table . " VALUES ('" . $personne[0]->getPerNum() . "','" . $object[0]->getAptCode() . "')");
        } else
            DataBase::$db->majDonnees("UPDATE " . self::$table . " SET APT_CODE = '" . $object[0]->getAptCode() . "' WHERE PER_NUM = '" . $object[0]->getPerNum() . "'");

    }
}