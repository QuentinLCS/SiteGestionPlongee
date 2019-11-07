<?php


abstract class _Model
{

    protected function _getAll($table, $entity) {
        return DataBase::$db->LireDonnees('SELECT * FROM '.$table, $entity);
    }

    protected function _countAll($table) {
        return DataBase::$db->LireDonnees('SELECT COUNT(*) as nb FROM '.$table);
    }

    protected function _getOne($table, $id, $entity) {
        $requete = 'SELECT * FROM '.$table.' WHERE ';
        $i = count($id);

        foreach ($id as $key=>$value)
            $requete .= $key .' = "'.$value.'"'.(--$i > 0 ? ' AND ' : ';');

        return DataBase::$db->LireDonnees($requete, $entity);
    }

    public abstract function getAll();
    public abstract function countAll();
    public abstract function getOne(array $id);
    public abstract function update($object, $add = false);
}