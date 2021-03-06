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

    public function getAllDirecteur()
    {
        return DataBase::$db->LireDonnees('SELECT * FROM '.self::$table.' JOIN PLO_DIRECTEUR USING (PER_NUM)', self::$entity);
    }

    public function getAllSecurite()
    {
        return DataBase::$db->LireDonnees('SELECT * FROM '.self::$table.' JOIN PLO_SECURITE_DE_SURFACE USING (PER_NUM)', self::$entity);
    }

    public function getCertificatDepasse()
    {
        return DataBase::$db->LireDonnees("SELECT count(*) as nb FROM PLO_PERSONNE WHERE DATE_ADD(PER_DATE_CERTIF_MED,INTERVAL 1 YEAR)< (SELECT CURRENT_DATE()) OR PER_DATE_CERTIF_MED = '0000-00-00'");
    }

    public function getSearchResult($search)
    {
        $sql = 'SELECT * FROM '.self::$table.' WHERE ';
        if (isset($search['nom'])) {
            $sql .= "PER_NOM LIKE '" . $search['nom'] . "%' ";

            if (isset($search['prenom']) || isset($search['inactive'])) $sql .= 'AND ';
        }
        if (isset($search['prenom'])) {
            $sql .= "PER_PRENOM LIKE '" . $search['prenom'] . "%' ";

            if (isset($search['inactive'])) $sql .= 'AND ';
        }

        if (isset($search['inactive']))
            $sql .= "PER_ACTIVE = '".$search['inactive']."'";

        return  DataBase::$db->LireDonnees($sql, self::$entity);
    }

    public function countAll()
    {
        return parent::_countAll(self::$table);
    }

    public function countActifs()
    {
        return DataBase::$db->LireDonnees('SELECT COUNT(*) as nb FROM '.self::$table." WHERE PER_ACTIVE = '1'");
    }

    public function getOne(array $id)
    {
        return parent::_getOne(self::$table, $id, self::$entity);
    }

    public function update($object, $add = false)
    {
        if ($add)
            DataBase::$db->majDonnees('INSERT INTO '.self::$table.' (PER_NOM, PER_PRENOM, PER_DATE_CERTIF_MED) VALUES ("'.$object[0]->getPerNom().'", "'.$object[0]->getPerPrenom().'", "'.$object[0]->getPerDateCertifMed().'")');
        else
            DataBase::$db->majDonnees("UPDATE ".self::$table." SET PER_NOM = '".$object[0]->getPerNom()."', PER_PRENOM = '".$object[0]->getPerPrenom()."', PER_DATE_CERTIF_MED = '".$object[0]->getPerDateCertifMed()."', PER_ACTIVE = '".$object[0]->getPerActive()."' WHERE PER_NUM = '".$object[0]->getPerNum()."'");
    }
}