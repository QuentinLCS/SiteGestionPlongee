<?php


abstract class _Model
{
    protected function getAll($table, &$sortie) {
        DataBase::$db->LireDonneesPDO2('SELECT * FROM '.$table, $sortie);
    }

    protected function countAll($table, &$sortie) {
        DataBase::$db->LireDonneesPDO2('SELECT COUNT(*) as nb FROM '.$table, $sortie);
    }

    /*
     * public function get($table, $id, &$sortie) {
        DataBase::$db->LireDonneesPDO2('SELECT * FROM '.$table.' WHERE ', $sortie);
    }*/
}