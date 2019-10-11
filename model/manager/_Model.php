<?php


abstract class _Model
{
    protected function getAll($table, $entity, &$sortie) {
        DataBase::$db->LireDonnees('SELECT * FROM '.$table, $entity, $sortie);
    }

    protected function countAll($table, $entity, &$sortie) {
        DataBase::$db->LireDonnees('SELECT COUNT(*) as nb FROM '.$table, $entity, $sortie);
    }

    /*
     * public function get($table, $id, &$sortie) {
        DataBase::$db->LireDonneesPDO2('SELECT * FROM '.$table.' WHERE ', $sortie);
    }*/
}