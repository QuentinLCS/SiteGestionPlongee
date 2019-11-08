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

    public function getPlongeesFutures()
    {
        return DataBase::$db->LireDonnees('SELECT * FROM '.self::$table.' WHERE PLO_ETAT NOT LIKE "VALIDEE%"' , self::$entity);
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
                " . $object[0]->getPloEffectifBateau(). ",0,'".$object[0]->getPloEtat()."')");
            //TODO faire la selection pour les deux dernières valeurs
        }
        else
        {
            DataBase::$db->majDonnees("UPDATE ".self::$table.
                " SET SIT_NUM=".$object[0]->getSitNum().
                " ,EMB_NUM=".$object[0]->getEmbNum().
                " ,PER_NUM_DIR=".$object[0]->getPerNumDir().
                " ,PER_NUM_SECU=".$object[0]->getPerNumSecu().
                " ,PLO_EFFECTIF_PLONGEURS=".$object[0]->getPloEffectifPlongeurs().
                " ,PLO_EFFECTIF_BATEAU=".$object[0]->getPloEffectifBateau().
                " ,PLO_NB_PALANQUEES=".$object[0]->getPloNbPalanquees().
                " ,PLO_ETAT='".$object[0]->getPloEtat()."'
                WHERE PLO_DATE='".$object[0]->getPloDate()."'
                AND PLO_MAT_MID_SOI='".$object[0]->getPloMatMidSoi()."'");
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

    public function deleteConcerner($object) {
        $req = "DELETE FROM PLO_CONCERNER WHERE PLO_DATE='".$object['plo_date']."' AND PLO_MAT_MID_SOI='".$object['plo_mat_mid_soi']."' AND PAL_NUM = ".$object['pal_num']." AND PER_NUM = ".$object['per_num'];
        DataBase::$db->majDonnees($req);
    }
    public function getEffectifPlongeur($date,$periode)
    {
        $req="SELECT count(PLO_CONCERNER.PER_NUM) from PLO_PLONGEE
                join PLO_PALANQUEE USING(PLO_DATE,PLO_MAT_MID_SOI)
                join PLO_CONCERNER USING(PLO_DATE,PLO_MAT_MID_SOI,PAL_NUM)
                WHERE PLO_DATE='$date' 
                AND PLO_MAT_MID_SOI='$periode'";
        return DataBase::$db->LireDonnees($req);
    }
    public function addPlongeurs($plongee, $plongeur, $pal_num){
        $req = 'INSERT INTO PLO_CONCERNER (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PER_NUM) VALUES (
                    "'.$plongee[0]->getPloDate().'",
                    "'.$plongee[0]->getPloMatMidSoi().'"
                    '.$pal_num.'
                    '.$plongeur[0]->getPerNum().')';
    }

    public function getDirecteur($object){
        return DataBase::$db->LireDonnees('SELECT * FROM PLO_DIRECTEUR WHERE PER_NUM ="'.$object[0]->getPerNumDir().'"','Personne');
    }

    public function getSecurite($object){
        return DataBase::$db->LireDonnees('SELECT * FROM PLO_SECURITE_DE_SURFACE WHERE PER_NUM ="'.$object[0]->getPerNumSecu().'"','Personne');
    }


}