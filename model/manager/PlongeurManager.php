<?php

require_once('_Model.php');

class PlongeurManager extends _Model
{
    public static $entity = 'Plongeur';
    public static $table = 'PLO_PLONGEUR';

    private $personneManager;

    public function __construct()
    {
        $this->personneManager = new PersonneManager();
    }

    public function getAll()
    {
        return parent::_getAll(self::$table, self::$entity);
    }

    public function getAllActive()
    {
        $req = 'SELECT * FROM PLO_PLONGEUR JOIN PLO_PERSONNE USING(PER_NUM) WHERE PER_ACTIVE  =  1';
        return DataBase::$db->LireDonnees($req, self::$entity);
    }

    public function getSearchResult($search)
    {
        $personnes = $this->personneManager->getSearchResult($search);

        $nbPersonnes = count($personnes);

        if ($nbPersonnes > 0) {
            $sql = 'SELECT * FROM ' . self::$table . ' WHERE PER_NUM IN (';

            $i = 0;

            foreach ($personnes as $personne) {
                $sql .= $personne->getPerNum() . (++$i < $nbPersonnes ? ',' : ')');
            }

            return DataBase::$db->LireDonnees($sql, self::$entity);
        }

         return [];
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

    public function delete($object){

        $req = 'SELECT PAL_NUM FROM PLO_PLONGEUR JOIN PLO_CONCERNER USING(PER_NUM) JOIN PLO_PALANQUEE USING(PAL_NUM) WHERE PER_NUM = '.$object[0]->getPerNum();
        $tab = DataBase::$db->LireDonnees($req);
        //si le plongeur n'a pas de plongée on le supprime de la table PLO_PLONGEUR
        if (count($tab) == 0) {
            DataBase::$db->majDonnees('DELETE FROM PLO_PLONGEUR WHERE PER_NUM = '.$object[0]->getPerNum());
        } else {
            //sinon on le rend inactif
            echo "vous ne pouvez pas supprimer ce plongeur car il a des plongées";
            DataBase::$db->majDonnees('UPDATE PLO_PERSONNE SET PER_ACTIVE = 0 WHERE PER_NUM = '.$object[0]->getPerNum());
        }
    }
    public function getPlongeurPlongee($date,$periode)
    {
        $req="SELECT * FROM PLO_PLONGEE
                JOIN PLO_PALANQUEE using (PLO_DATE,PLO_MAT_MID_SOI)
                JOIN PLO_CONCERNER USING (PLO_DATE,PLO_MAT_MID_SOI)
                JOIN PLO_PERSONNE USING (PER_NUM)
                JOIN `PLO_PLONGEUR` USING (`PER_NUM`)
                JOIN `PLO_APTITUDE` USING (`APT_CODE`)
                WHERE PLO_DATE='$date' and PLO_MAT_MID_SOI='$periode'";
        return DataBase::$db->LireDonnees($req,self::$entity);
    }
}