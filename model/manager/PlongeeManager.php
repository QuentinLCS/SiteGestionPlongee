<?php

require_once('_Model.php');

class PlongeeManager extends _Model
{
    public static $entity = 'Plongee';
    public static $table = 'PLO_PLONGEE';

    public function getAll()
    {
        return parent::_getAll(self::$table, self::$entity);
    }

    public function getSearchResult($search)
    {
        $sql = 'SELECT * FROM '.self::$table.' WHERE ';
        if (isset($search['date'])) {
            $sql .= "PLO_DATE LIKE '" . $search['date'] . "%'";

            if (isset($search['periode'])) $sql .= 'AND ';
        }
        if (isset($search['periode']))
            $sql .= "PLO_MAT_MID_SOI LIKE '".$search['periode']."%'";

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
        if ($add) {
            DataBase::$db->majDonnees("INSERT INTO " . self::$table ." (PLO_DATE, PLO_MAT_MID_SOI, SIT_NUM, EMB_NUM, PER_NUM_DIR, PER_NUM_SECU, PLO_EFFECTIF_PLONGEURS, PLO_EFFECTIF_BATEAU, PLO_NB_PALANQUEES, PLO_ETAT) 
            VALUES (
                '". $object[0]->getPloDate() . "',
                '" . $object[0]->getPloMatMidSoi() . "',
                " . $object[0]->getSitNum().",
                " . $object[0]->getEmbNum().",
                " . $object[0]->getPerNumDir().",
                " . $object[0]->getPerNumSecu().",
                " . $object[0]->getPloEffectifPlongeurs().",
                " . $object[0]->getPloEffectifBateau(). ",0,'')");
        }
    }

    public function delete($object){
        $pal = 'SELECT PAL_NUM FROM PLO_PALANQUEE WHERE PLO_DATE = "'.$object[0]->getPloDate().'" AND PLO_MAT_MID_SOI ="'.$object[0]->getPloMatMidSoi().'"';
        if(count($pal)>0){
            $concerne = 'SELECT * FROM PLO_CONCERNER WHERE PLO_DATE = "'.$object[0]->getPloDate().'" AND PLO_MAT_MID_SOI ="'.$object[0]->getPloMatMidSoi().'"';
            if(count($concerne)>0){
                $req1 = 'DELETE FROM PLO_CONCERNER WHERE PLO_DATE = "'.$object[0]->getPloDate().'" AND PLO_MAT_MID_SOI ="'.$object[0]->getPloMatMidSoi().'"';
                DataBase::$db->majDonnees($req1);
            }
            $req2 = 'DELETE FROM PLO_PALANQUEE WHERE PLO_DATE = "'.$object[0]->getPloDate().'" AND PLO_MAT_MID_SOI ="'.$object[0]->getPloMatMidSoi().'"';
            DataBase::$db->majDonnees($req2);
        }
        $req3 = 'DELETE FROM PLO_PLONGEE WHERE PLO_DATE = "'.$object[0]->getPloDate().'" AND PLO_MAT_MID_SOI ="'.$object[0]->getPloMatMidSoi().'"';
        DataBase::$db->majDonnees($req3);
    }
}