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
            //INSERT INTO PLO_PALANQUEE (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PAL_PROFONDEUR_MAX, PAL_DUREE_MAX, PAL_HEURE_IMMERSION, PAL_HEURE_SORTIE_EAU, PAL_PROFONDEUR_REELLE, PAL_DUREE_FOND)
            // VALUES ('', '', '', NULL, NULL, NULL, NULL, NULL, NULL)
            echo "INSERT INTO " . self::$table ." (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PAL_PROFONDEUR_MAX, PAL_DUREE_MAX, PAL_HEURE_IMMERSION, PAL_HEURE_SORTIE_EAU, PAL_PROFONDEUR_REELLE, PAL_DUREE_FOND) 
            VALUES (
                '". $object[0]->getPloDate() . "',
                '" . $object[0]->getPloMatinApresmidi() . "',
                " . $object[0]->getPalNum().",
                " . $object[0]->getPalProfondeurMax().",
                " . $object[0]->getPalDureeMax().",
                '" . $object[0]->getPalHeureImmersion()."',
                '" . $object[0]->getPalHeureSortieEau()."',
                " . $object[0]->getPalProfondeurReelle(). ",
                " . $object[0]->getPalDureeFond(). "
                )";
            DataBase::$db->majDonnees("INSERT INTO " . self::$table ." (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PAL_PROFONDEUR_MAX, PAL_DUREE_MAX, PAL_HEURE_IMMERSION, PAL_HEURE_SORTIE_EAU, PAL_PROFONDEUR_REELLE, PAL_DUREE_FOND) 
            VALUES (
                '". $object[0]->getPloDate() . "',
                '" . $object[0]->getPloMatinApresmidi() . "',
                " . $object[0]->getPalNum().",
                " . $object[0]->getPalProfondeurMax().",
                " . $object[0]->getPalDureeMax().",
                '" . $object[0]->getPalHeureImmersion()."',
                '" . $object[0]->getPalHeureSortieEau()."',
                " . $object[0]->getPalProfondeurReelle(). ",
                " . $object[0]->getPalDureeFond(). "
                )");
        }
    }
    public function getPlongeePalanquee($donne1,$donne2)
    {
        $req="select * from ".self::$table." join PLO_PLONGEE using (PLO_DATE,PLO_MAT_MID_SOI) WHERE PLO_DATE='$donne1' and PLO_MAT_MID_SOI='$donne2'";
        return DataBase::$db->LireDonnees($req,self::$entity);
    }
}