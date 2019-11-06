<?php

require_once('_Model.php');

class AptitudeManager extends _Model
{
    public static $entity = 'Aptitude';
    public static $table = 'PLO_APTITUDE';

    public function getAll()
    {
        return DataBase::$db->LireDonnees('SELECT * FROM '.self::$table.' ORDER BY APT_NUM', self::$entity);
    }

    public function getSearchResult($search)
    {
        $sql = 'SELECT * FROM '.self::$table.' WHERE ';
        if (isset($search['code'])) {
            $sql .= "APT_CODE LIKE '" . $search['code'] . "%'";

            if (isset($search['libelle'])) $sql .= 'AND ';
        }
        if (isset($search['libelle']))
            $sql .= "APT_LIBELLE LIKE '".$search['libelle']."%'";

        $sql.= "ORDER BY APT_NUM";


        return  DataBase::$db->LireDonnees($sql, self::$entity);
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
            DataBase::$db->majDonnees("INSERT INTO ".self::$table." (APT_CODE, APT_LIBELLE, APT_NUM) VALUES ('".$object[0]->getAptCode()."', '".$object[0]->getAptLibelle()."','".$object[0]->getAptNum()."')");
        else
            DataBase::$db->majDonnees("UPDATE ".self::$table." SET APT_CODE = '".$object[0]->getAptCode()."', APT_LIBELLE = '".$object[0]->getAptLibelle()."', APT_NUM = '".$object[0]->getAptNum()."' WHERE APT_CODE = '".$object[0]->getOldAptCode()."'");
    }


    public function delete($object){
        $apt = DataBase::$db->LireDonnees('SELECT * FROM PLO_PLONGEUR WHERE APT_CODE = "'.$object[0]->getAptCode().'"');
        if(count($apt)==0)
            DataBase::$db->majDonnees('DELETE FROM PLO_APTITUDE WHERE APT_CODE ="'.$object[0]->getAptCode().'"');
    }


}