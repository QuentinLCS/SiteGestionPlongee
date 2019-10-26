<?php

require_once('_Model.php');

class PalanqueeManager extends _Model
{
    public static $entity = 'Palanquee';
    public static $table = 'PLO_PALANQUEE';

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
        if ($add) {
            DataBase::$db->majDonnees("INSERT INTO " . self::$table ." (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PAL_PROFONDEUR_MAX, PAL_DUREE_MAX, PAL_HEURE_IMMERSION, PAL_HEURE_SORTIE_EAU, PAL_PROFONDEUR_REELLE, PAL_DUREE_FOND) 
            VALUES (
                '". $object[0]->getPloDate() . "',
                '" . $object[0]->getPloMatMidSoi() . "',
                " . $object[0]->getPalNum().",
                " . $object[0]->getPalProfondeurMax().",
                " . $object[0]->getPalDureeMax().",
                '" . $object[0]->getPalHeureImmersion()."',
                '" . $object[0]->getPalHeureSortieEau()."',
                " . $object[0]->getPalProfondeurReelle(). ",
                " . $object[0]->getPalDureeFond(). "
                )");
        }
        else {
            var_dump($object);
            $sql="UPDATE " . self::$table . " SET 
             PAL_PROFONDEUR_MAX ='" . $object[0]->getPalProfondeurMax() . "',
             PAL_DUREE_MAX ='" . $object[0]->getPalDureeMax() . "',
             PAL_HEURE_IMMERSION ='" . $object[0]->getPalHeureImmersion() . "' ";

            if(!($object[0]->getPalHeureSortieEau()==null))
              $sql.=", PAL_HEURE_SORTIE_EAU ='" . $object[0]->getPalHeureSortieEau() . "'" ;
            if(!($object[0]->getPalProfondeurReelle()==null))
                $sql.=", PAL_PROFONDEUR_REELLE ='" . $object[0]->getPalProfondeurReelle() . "'";
            if(! ($object[0]->getPalDureeFond()  == null))
                $sql.=", PAL_DUREE_FOND ='" . $object[0]->getPalDureeFond() . "'";

            $sql.=" WHERE PAL_NUM = '". $object[0]->getPalNum() ."' AND PLO_MAT_MID_SOI ='". $object[0]->getPloMatMidSoi() ."' AND PLO_DATE ='". $object[0]->getPloDate()."'";
            var_dump($sql);
            DataBase::$db->majDonnees($sql);
        }
    }
    public function getPlongeurEffecif($date,$periode)
    {
        $req="SELECT count(*) from PLO_PALANQUEE where PLO_DATE='$date' and PLO_MAT_MID_SOI='$periode'";
        return DataBase::$db->LireDonnees($req);
    }

    public function updatePlongeurs($object) {
        ;
        DataBase::$db->majDonnees("INSERT INTO PLO_CONCERNER (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PER_NUM) 
        VALUES (
        '". $object['PLO_DATE'] ."',
        '". $object['PLO_MAT_MID_SOI'] ."',
        ". $object['PAL_NUM'] .",
        ". $object['PER_NUM'] ."
        );");
    }

    public function getPlongeePalanquee($ploDate,$matMidSoi)
    {
        $req="select * from ".self::$table." join PLO_PLONGEE using (PLO_DATE,PLO_MAT_MID_SOI) WHERE PLO_DATE='$ploDate' and PLO_MAT_MID_SOI='$matMidSoi'";
        return DataBase::$db->LireDonnees($req,self::$entity);
    }
}