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
        // TODO: Implement update() method.
    }
}