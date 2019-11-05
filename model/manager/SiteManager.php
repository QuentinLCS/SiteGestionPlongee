<?php

require_once('_Model.php');

class SiteManager extends _Model
{
    public static $entity = 'Site';
    public static $table = 'PLO_SITE';

    private $siteManager;

    public function __construct()
    {
        $this->siteManager = new PersonneManager();
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

    public function getSearchResult($search)
    {
        $sql = 'SELECT * FROM '.self::$table.' WHERE ';
        if (isset($search['nom']))
            $sql .= "SIT_NOM LIKE '" . $search['nom'] . "%' ";

        return  DataBase::$db->LireDonnees($sql, self::$entity);
    }

    public function update($object, $add = false)
    {
        DataBase::$db->majDonnees("UPDATE ".self::$table." SET SIT_NOM = '".$object[0]->getSitNom()."', SIT_LOCALISATION = '".$object[0]->getSitLocalisation()."' WHERE SIT_NUM = '".$object[0]->getSitNum()."'");
    }

    public function add($object){
        DataBase::$db->majDonnees("INSERT INTO ".self::$table." ( SIT_NOM, SIT_LOCALISATION) VALUES ('".$object->getSitNom()."','".$object->getSitLocalisation()."')");
    }
    public function getSitePlongee($valeur)
    {
        $req="select * from ".self::$table." join PLO_PLONGEE using (SIT_NUM) WHERE SIT_NUM=$valeur";
        return DataBase::$db->LireDonnees($req,self::$entity);
    }

    public function delete($object){
        $sql = 'SELECT * FROM PLO_PLONGEE WHERE SIT_NUM = '.$object[0]->getSitNum();
        $tab = DataBase::$db->LireDonnees($sql);

        if(count($tab)==0)
            DataBase::$db->majDonnees('DELETE FROM PLO_SITE WHERE SIT_NUM = '.$object[0]->getSitNum());

    }
}